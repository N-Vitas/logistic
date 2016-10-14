<?php
use yii\grid\GridView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $dateFrom string
 * @var $dateTo string
 */

\moonland\phpexcel\Excel::export([
    'models' => $dataProvider->query->all(),
    'columns' => [
        'username',
        [
            'attribute' => 'orderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getOrdersCount($dateFrom, $dateTo);
            }
        ],
    ],
]);