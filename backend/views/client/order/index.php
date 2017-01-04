<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ListView;
use \common\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы клиента на доставку ' . $client->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <div class="row">
        <div class="col-md-3">
            <?= Html::a('< Вернуться в карточку клиента', ['/client/view', 'id' => $client->id], ['class' => 'btn btn-success btn-block']) ?>            
        </div>
        <div class="col-md-2 col-md-offset-5">
            <?= Html::a('Отчет по платежам', ['/analytic/payments'], ['class' => 'btn btn-success btn-block']) ?>            
        </div>
        <div class="col-md-2">            
            <?= Html::a('Отчет по доставкам', ['/analytic/delivery'], ['class' => 'btn btn-success btn-block']) ?>
        </div>
    </div>

    <div class="pull-right" style="margin-bottom: 15px;">
    </div>

    <hr>
    <?= \common\widgets\DeliveryStatus::widget(['client_id' => $client->id]) ?>

    <?= \common\widgets\PageViewContentForm::widget(['view'=> $view])?>

    <?php if($view == 'table'):?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            'attribute' => 'id',
            'value' => function($model) {
                return sprintf("%09d", $model->id);
            },
            // 'contentOptions' =>['class' => 'table_class','style'=>'width:10px;'],
          ],
          [
            'attribute' => 'created_at',
            // 'format' => 'raw',
            'value' => 'created_at',
            'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'language' => 'ru',
                        // 'size' => 'lg',
                        'attribute' => 'created_at',
                        // 'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    'clearBtn'=>true,
                    ]
                        ])
          ],
          [
            'attribute' => 'city.title',
            'format' => 'raw',
            'filter' => Html::activeInput('text', $searchModel, 'city', ['class' => 'form-control'])
          ],
            'address',
            'client_name',
            'phone',
            // 'product_id',
            // 'email:email',
          [
            'attribute' => 'paymentType',
            'format' => 'raw',
            // 'value' => function($model) {
            //     return $model->getOrderStatus();
            // },
            'filter' => Html::activeDropDownList($searchModel, 'payment_type', Order::$paymentTypes,['class' => 'form-control']),
          ],
            'price',
          [
            'attribute' => 'orderStatus',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getOrderStatus();
            },
            'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'orderStatus', Order::$statuses,['class' => 'form-control']),
          ],

            'delivery_date',

            
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
        'itemView' => 'payments_list',
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'news-item',
        ],
    ]);?>
    <?php endif;?>

</div>
