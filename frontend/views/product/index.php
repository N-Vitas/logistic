<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Остаток на складе';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= Html::a('Оформить заказ на доставку', ['order/create'], ['class' => 'btn btn-info btn-block']) ?>            
        </div>
        <div class="col-md-offset-6 col-md-3">
            <?= Html::a('Отчет по остаткам', ['analytic/product'], ['class' => 'btn btn-success btn-block']) ?> 
        </div>
    </div>
    <p></p>
    <?= \common\widgets\ClientEndingProducts::widget(['client_id' => \Yii::$app->user->getIdentity()->client_id]) ?>
    <?= \common\widgets\PageViewContentForm::widget(['view'=> $view])?>
    <?php if($view == 'table'):?>
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
    <?php else:?>
    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
    <p></p>
    <div class="input-group">
      <?= $form->field($searchModel, 'title',['template'=>'{input}'])->textInput(['placeholder' => 'Искать по наименованию'])?>
      <span class="input-group-btn">
        <button class="btn btn-info" type="button">Поиск</button>
      </span>
    </div>
    <?php ActiveForm::end(); ?> 
    <?= ListView::widget([        
        'dataProvider' => $dataProvider,
        'itemView' => 'product_list',
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'news-item',
        ],
    ]);?>
    <?php endif;?>
</div>
