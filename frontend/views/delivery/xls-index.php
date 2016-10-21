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
        'paymentType',
        'price',

        [
            'attribute' => 'orderStatus',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getOrderStatus(false);
            },

        ],

        'delivery_date',
    ], //without header working, because the header will be get label from attribute label.
//    'header' => ['column1' => 'Header Column 1','column2' => 'Header Column 2', 'column3' => 'Header Column 3'],
]);