<?php
use yii\grid\GridView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

\moonland\phpexcel\Excel::export([
    'models' => $dataProvider->query->all(),
    'columns' => [
        [
          'value' => 'product.title',
          'attribute' => 'product_title'
        ],
        [
          'value' => 'product.nomenclature',
          'attribute' => 'product_nomenclature'
        ],
        [
          'value' => 'product.barcode',
          'attribute' => 'product_barcode'
        ],
        [
          'value' => 'product.code_client',
          'attribute' => 'product_code_client'
        ],
        // [
        //     'attribute' => 'created_at',
        //     // 'format' => 'raw',
        //     'value' => 'created_at',
        //     'filter' => DatePicker::widget([
        //       'model' => $searchModel,
        //       'language' => 'ru',
        //       // 'size' => 'lg',
        //       'attribute' => 'created_at',
        //       // 'template' => '{addon}{input}',
        //       'clientOptions' => [
        //           'autoclose' => true,
        //           'format' => 'yyyy-mm-dd',
        //           'clearBtn'=>true,
        //       ]
        //     ])
        //   ],
        'increase',
        'decrease',
    ]
]);
