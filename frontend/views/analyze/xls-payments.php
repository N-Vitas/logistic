<?php
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

\moonland\phpexcel\Excel::export([
    'models' => $dataProvider->query->all(),
    'columns' => [
        'id',
        'created_at',
        'city.title',
        'address',
        'client_name',
        'phone',
        'paymentType',
        'price',
        [
            'attribute' => 'orderStatus',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getOrderStatus(false);
            },
            'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'orderStatus', \common\models\Order::$statuses),

        ],
        'delivery_date',
    ],
]);