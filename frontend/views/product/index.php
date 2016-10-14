<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Остаток на складе';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="pull-right">
        <?= Html::a('Отчет по остаткам', ['analyze'], ['class' => 'btn btn-success']) ?>
    </div>

    <p>
        <?= Html::a('Оформить заказ на доставку', ['order/create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= \common\widgets\ClientEndingProducts::widget(['client_id' => \Yii::$app->user->getIdentity()->client_id]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => array_merge(
            array_merge([['class' => 'yii\grid\SerialColumn'], 'title'], $columns),
            [
                'nomenclature',
                'balance',
                [
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::a('<i class="fa fa-truck"></i>', ['order/create', 'product_id' => $model->id], [
                            'class' => 'btn btn-success'
                        ]);
                    },
                    'contentOptions'=>['style'=>'width: 50px;']
                ],
                // 'created_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function($url, $model, $key) {
                            return \yii\helpers\Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
                                'class' => 'btn btn-info'
                            ]);
                        }
                    ],
                    'contentOptions'=>['style'=>'width: 50px;']
                ]
            ]
        )
    ]); ?>

</div>
