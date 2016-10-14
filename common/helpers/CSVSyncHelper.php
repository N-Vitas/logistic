<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 28-мар-16
 * Time: 06:02
 */

namespace common\helpers;


use common\models\Order;
use common\models\OrderItem;
use common\models\OrderLog;
use common\models\Product;
use common\models\SyncLog;
use yii\helpers\VarDumper;

class CSVSyncHelper
{
    public static function parseCSV($csvText)
    {
        $array = [];

        $csvText = mb_convert_encoding($csvText, 'UTF-8');

        $csvSplit = explode("\n", $csvText);
        foreach ($csvSplit as $csvRow) {
            $array[] = str_getcsv($csvRow);
        }
        $keys = array_shift($array);
        foreach ($array as $i => $row) {
            if (count($keys) != count($row)) {
                continue;
            }
            $array[$i] = array_combine($keys, $row);
        }

        return $array;
    }

    public static function importCSVProducts($csvText)
    {
        $array = self::parseCSV($csvText);
        $created = 0;
        $updated = 0;
        $errors = 0;
        foreach ($array as $b) {
            $a = [];
            foreach ($b as $key => $value) {
                $k = mb_strtolower($key);
                $a[$k] = $value;
            }
            if (!isset($a['client_id'])) {
                continue;
            }

            $obj = Product::findOne([
                'client_id' => $a['client_id'],
                'article' => $a['article']
            ]);

            if (empty($obj)) {
                $obj = new Product($a);
                if (!$obj->title) {
                    $obj->title = $a['nomenclature'];
                }

                $created++;
            } else {
                $updated++;
            }

            $obj->updated_at = time();

            if (!$obj->save()) {
                $errors++;
            }
        }

        SyncLog::logImportProducts($created, $updated, $errors);
    }

    public static function importCSVOrders($csvText)
    {
        $array = self::parseCSV($csvText);
        $updated = 0;
        $created = 0;
        $errors = 0;
        foreach ($array as $b) {
            if (sizeof($b) < 2) {
                continue;
            }

            $a = [];
            foreach ($b as $key => $value) {
                $k = mb_strtolower($key);
                $a[$k] = $value;
            }

            $obj = new OrderLog($a);

            $order = Order::findOne(['id' => $obj->order_id]);
            if (!isset($order->id)) {
                continue;
            }

            if (!$obj->save()) {
                $errors++;
            } else {
                $created++;

                if ($order->updated_at < $obj->status_date) {
                    $order->status = $obj->status;
                    $order->updated_at = $obj->status_date;
                    $order->save();
                    $updated++;
                }
            }
        }

        SyncLog::logImportOrders($created, $updated, $errors);
    }

    public static function exportCSVOrders()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        $columns = [
            'orders.id',
            'orders.created_at',
            'orders.client_id',
            'orders.client_name',
            'orders.address',
            'orders.phone',
            'orders.email',
            'orders.payment_type',
            'orders.price',
            'orders.delivery_date',
            'orders.status',
            'orders.city_id',
        ];

        $itemColumns = [
            'order_item.item_id',
            'order_item.quantity',
            'order_item.price',
            'products.title',
            'products.article',
            'products.nomenclature',
            'products.code_client',
        ];

        $orders = Order::find()
            ->select($columns)
//            ->where(['exported' => 0])
            ->asArray()
            ->all();

        Order::updateAll(['exported' => 1]);


// output the column headings
        fputcsv($output, array_merge(
            $columns,
            $itemColumns
        ));
//
//// fetch the data
//
// loop over the rows, outputting them
        foreach ($orders as $order) {
            $orderItems = OrderItem::find()
                ->select($itemColumns)
                ->joinWith('product')
                ->where(['order_id' => $order])
                ->asArray()
                ->all();
//            print_r($orderItems);
            foreach ($orderItems as $orderItem) {
                unset($orderItem['product']);
                fputcsv($output, array_merge(
                    $order,
                    $orderItem
                ));
            }
        }
    }
}