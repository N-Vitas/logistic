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
use common\models\ProductAnalytics;
use common\models\SyncLog;
use yii\helpers\VarDumper;

class DBSyncHelper
{
    public static function getSyncStatus($key)
    {
        return \Yii::$app->db->createCommand(
            "SELECT status FROM one_c.sync_status WHERE name = '$key'"
        )->queryScalar();
    }

    public static function setSyncStatus($key, $status)
    {
        return \Yii::$app->db->createCommand(
            "UPDATE one_c.sync_status SET status = $status WHERE name = '$key'"
        )->execute();
    }
    //actionImportProducts 
    public static function importProducts()
    {
        /*
        $analytics = new ProductAnalytics(['product_id' => $this->id,'created_at' => date('Y-m-d', time())]);
    //     //       $analytics->increase = 0; // Приход
    //     //       $analytics->decrease = $this->reserve; // Уход
    //     //       $analytics->save();
        */
        $array = \Yii::$app->db->createCommand("SELECT * FROM one_c.tovars")
            ->queryAll();
        $created = 0;
        $updated = 0;
        $errors = 0;
        foreach ($array as $a) {
            $obj = Product::findOne([
                'client_id' => $a['client_id'],
                'nomenclature' => $a['nomenclature']
            ]);


            if (empty($obj)) {
                $obj = new Product($a);
                $created++;
            } else {
                $updated++;
            }
            $obj->balance = (int) preg_replace('/\D/',"",$a['balance']);
            if($obj->reserve != 0){
                $obj->balance = $obj->balance - $obj->reserve;
            }          
            $obj->updated_at = time();

            if (!$obj->save()) {
                $errors++;
                print_r($obj->getErrors());
            }
        }

        SyncLog::logImportProducts($created, $updated, $errors);
        self::setSyncStatus('tovars', 0);
    }

    public static function changeProductStatus($orderItemId,$status){
        switch ($status) {
            case Order::STATUS_DELIVERING:
                $orderItems = OrderItem::find()
                ->where(['order_id' => $order['id']])
                ->all();
                if($orderItems){
                    foreach ($orderItems as $orderItem) {
                        $product = Product::findOne($orderItem->item_id);
                        if($product){
                            if($product->reserve > 0){
                                $analytics = new ProductAnalytics(['product_id' => $product->id,'created_at' => date('Y-m-d', time())]);
                                if($analytics){
                                    $analytics->increase = 0; // Приход
                                    $analytics->decrease = $product->reserve; // Уход
                                    $analytics->save();                                    
                                }
                                $product->reserve = 0;
                                $product->save();

                            }
                        }
                    }                    
                }
                break;
            case Order::STATUS_COMPLETE:
                $orderItems = OrderItem::find()
                ->where(['order_id' => $order['id']])
                ->all();
                if($orderItems){
                    foreach ($orderItems as $orderItem) {
                        $product = Product::findOne($orderItem->item_id);
                        if($product){
                            if($product->reserve > 0){
                                $analytics = new ProductAnalytics(['product_id' => $product->id,'created_at' => date('Y-m-d', time())]);
                                if($analytics){
                                    $analytics->increase = 0; // Приход
                                    $analytics->decrease = $product->reserve; // Уход
                                    $analytics->save();                                    
                                }
                                $product->reserve = 0;
                                $product->save();

                            }
                        }
                    }                    
                }
                break;
            case Order::STATUS_CANCELED:
                $orderItems = OrderItem::find()
                ->where(['order_id' => $order['id']])
                ->all();
                if($orderItems){
                    foreach ($orderItems as $orderItem) {
                        $product = Product::findOne($orderItem->item_id);
                        if($product){
                            if($product->reserve != 0){
                                $product->balance = $product->balance + $product->reserve;
                                $product->reserve = 0;
                                $product->save();
                            }
                        }
                    }                    
                }
                break;
        }
    }

    public static function importOrders()
    {
        $array = \Yii::$app->db->createCommand("SELECT * FROM one_c.status_orders")->queryAll();
        $updated = 0;
        $created = 0;
        $errors = 0;
        foreach ($array as $a) {
            $obj = new OrderLog($a);

            $order = Order::findOne(['id' => $obj->order_id]);
            if (!isset($order->id)) {
                continue;
            }
            self::changeProductStatus($obj->order_id,$obj->status);            
            if (!$obj->save()) {
                $errors++;
            } else {
                $created++;

                if ($order->updated_at < $obj->status_date) {
                    $order->status = $obj->status;
                    $order->status_payments = isset($obj->status_payments)?$obj->status_payments:0;
                    $order->updated_at = $obj->status_date;
                    $order->save();
                    $updated++;
                }
            }
        }

        SyncLog::logImportOrders($created, $updated, $errors);

        \Yii::$app->db->createCommand('TRUNCATE one_c.status_orders')->execute();
    }

    public static function exportOrders()
    {
        \Yii::$app->db->createCommand('TRUNCATE one_c.orders')
            ->execute();

        $output = [];

        $columns = [
            'orders.id',
            'orders.created_at',
            'orders.client_id',
            'orders.client_name',
            'orders.address',
            'orders.phone',
            'orders.email',
            'orders.city_id',
            'orders.payment_type'
        ];

        $itemColumns = [
            'order_item.quantity',
            'order_item.price',
            'order_item.item_id',
            'products.title',
            'products.nomenclature',
        ];

        $orders = Order::find()
            ->select($columns)
            ->where(['exported' => 0])
            ->andWhere(['>', 'orders.created_at', date('Y-m-d H:i:s', strtotime('-15 minutes', time()))])
            ->joinWith('city')
            ->asArray()
            ->all();


        // var_dump($orders);die;
        // loop over the rows, outputting them
        foreach ($orders as $order) {
            $order['address'] = $order['city']['title'] . ',' . $order['address'];
            unset($order['city']);
            unset($order['city_id']);

            $orderItems = OrderItem::find()
                ->select($itemColumns)
                ->joinWith('product')
                ->where(['order_id' => $order['id']])
                ->asArray()
                ->all();
            foreach ($orderItems as $orderItem) {
                unset($orderItem['product']);
                unset($orderItem['item_id']);
                $output[] = array_merge(
                    $order,
                    $orderItem
                );
            }
        }
        if (sizeof($output)) {
            foreach ($output as $row) {
                \Yii::$app->db->createCommand("
                      INSERT INTO `one_c`.`orders` (`id`, `created_at`, `client_id`, `client_name`, 
                      `address`, `phone`, `email`, `payment_type`, `quantity`, `item_price`, `title`, `nomenclature`) 
                      VALUES ('" . implode("', '", $row) . "')")
                    ->execute();
            }
        }
        Order::updateAll(['exported' => 1]);
    }
}
