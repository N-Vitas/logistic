<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <div class="row">
        <div class="col-xs-12 col-md-3">
            <?= Html::a('Оформить заказ на доставку', ['order/create'], ['class' => 'btn btn-info btn-block']) ?>            
        </div>
        <div class="col-xs-12 col-md-offset-6 col-md-3">
            <?= Html::a('Отчет по остаткам', ['analytic/product'], ['class' => 'btn btn-success btn-block']) ?> 
        </div>
    </div>
    <?= \common\widgets\DeliveryStatus::widget(['client_id' => \Yii::$app->user->getIdentity()->client_id]) ?>
    <p></p>
    <?= \common\widgets\PageViewContentForm::widget(['view'=> $view])?>
    <?php if($view == 'table'):?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            ],

            'delivery_date',

            [
                'format' => 'raw',
                'value' => function($model) {
                    $activeCancel = true;
                    if ((strtotime($model->created_at) - time()) > 15 * 60 || $model->status == $model::STATUS_CANCELED)
                        $activeCancel = false;

                    $cancelButton = Html::a('<i class="glyphicon glyphicon-trash"></i>',
                        ['cancel', 'id' => $model->id], [
                        'class' => 'btn btn-danger' . ($activeCancel ? ' disabled' : ''),
                        'data' => [
                            'confirm' => 'Вы точно хотите отменить заказ?',
                            'method' => 'post',
                        ],
                    ]);

                    $viewButton = Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                        ['view', 'id' => $model->id], [
                        'class' => 'btn btn-info'
                    ]);
                    return $cancelButton . $viewButton;
                }
            ]
        ],
    ]); ?>
    <?php else:?>
    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
    <p></p>
    <div class="input-group">
      <?= $form->field($searchModel, 'client_name',['template'=>'{input}'])->textInput(['placeholder' => 'Искать по клиенту'])?>
      <span class="input-group-btn">
        <button class="btn btn-info" type="button">Поиск</button>
      </span>
    </div>
    <?php ActiveForm::end(); ?> 
    <?= ListView::widget([        
        'dataProvider' => $dataProvider,
        'itemView' => 'order_list',
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'news-item',
        ],
    ]);?>
    <?php endif;?>
</div>
