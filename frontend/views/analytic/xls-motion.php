<?php
use yii\grid\GridView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

\moonland\phpexcel\Excel::export([
    'models' => $dataProvider->query->all(),
    'columns' => array_merge(
        array_merge([
            [
                'value' => 'product.title',
                'attribute' => 'product_title'
            ]
        ], $columns),
        [
            'created_at',
            'increase',
            'decrease',
            // 'created_at',
        ])
]);
