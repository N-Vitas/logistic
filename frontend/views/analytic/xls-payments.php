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
    // 'product_id',
    // 'email:email',
    // 'paymentType',
    'price',

    [
        'attribute' => 'orderStatus',
        'format' => 'raw',
        'value' => function($model) {
            return $model->getOrderStatus(false);
        },

    ],

    'delivery_date',
  ]
]); 