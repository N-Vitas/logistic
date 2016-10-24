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
            'attribute' => 'newOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getNewOrdersCount($dateFrom, $dateTo);
            }
        ],
        [
            'attribute' => 'workOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getWorkOrdersCount($dateFrom, $dateTo);
            }
        ],
        [
            'attribute' => 'completeOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getCompleteOrdersCount($dateFrom, $dateTo);
            }
        ],
    ],
]);