<?php
/**
 * Created by PhpStorm.
 * User: CrazyDeveloper
 * Date: 3-мая-16
 * Time: 02:08
 */

namespace common\models;


use yii\data\ActiveDataProvider;

class OrderPaymentsSearch extends Order
{
    public $products;
    public $orderStatus;

    public $priceFrom;
    public $priceTo;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['products', 'orderStatus'], 'safe']
        ]);
    }

    public static function search($client_id, $post, $dateFrom = false, $dateTo = false) {

        $query = self::find()
            ->where(['client_id' => $client_id]);
//            ->groupBy(['status']);

        if (!empty($post['products'])) {
            $products = json_decode($post['products'], true);
            $query->joinWith('items')->andWhere(['IN', 'item_id', $products]);
        }

        if (!empty($post['OrderAnalyticsSearch']['orderStatus'])) {
            $query->joinWith('items')->andWhere(['status' => $post['OrderAnalyticsSearch']['orderStatus']]);
        }

        if (!empty($dateFrom)) {
            $query->andWhere(['>=', 'created_at', date('Y-m-d 00:00:00', strtotime($dateFrom))]);
        }

        if (!empty($dateTo)) {
            $query->andWhere(['<=', 'created_at', date('Y-m-d 23:59:59', strtotime($dateTo))]);
        }

        $dataProvider = new ActiveDataProvider(['query' => $query, 'sort' => [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ]]);



        return $dataProvider;
    }
}