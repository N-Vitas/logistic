<?php

use \common\models\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ListView;

$this->title = 'Отчет по платежам';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \common\widgets\FilterDateRangeForm::widget(['filterModel' => $searchModel]) ?><p></p>
<?= \common\widgets\PaymentsStatus::widget(['client_id' => \Yii::$app->user->getIdentity()->client_id]) ?><p></p>
<div class="row">
	<div class="col-md-12">
    <?= \common\widgets\PageViewContentForm::widget(['view'=> $view])?>
    <?php if($view == 'table'):?>
		<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'tableOptions' => [
          'class' => 'table table-striped table-bordered'
      ],
      'columns' => [
          [
          	'attribute' => 'id',
            'value' => function($model) {
                return sprintf("%09d", $model->id);
            },
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
          // 'email:email',,
	        // [
         //    'attribute' => 'paymentType',
         //    'format' => 'raw',
         //    // 'value' => function($model) {
         //    //     return $model->getOrderStatus();
         //    // },
         //    'filter' => Html::activeDropDownList($searchModel, 'payment_type', Order::$paymentTypes,['class' => 'form-control']),
	        // ],
          // 'paymentType',
          'price',
	        [
            'attribute' => 'orderStatus',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getOrderStatus();
            },
            'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'orderStatus', Order::$statuses,['class' => 'form-control']),
	        ],
          [
            'attribute' => 'paymentStatus',
            'format' => 'raw',
            'value' => function ($model) {
              $status = Order::$statusesPayments[$model->status_payments];
              return \yii\bootstrap\Html::tag('span', $status, ['class'=>'label label-'.Order::$statusClasses[$model->status_payments]]);
            },
            'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'paymentStatus', Order::$statusesPayments,['class' => 'form-control']),
          ],
      //     [
      //     	'attribute' => 'delivery_date',
      //     	// 'format' => 'raw',
      //       'value' => 'delivery_date',
      //       'filter' => DatePicker::widget([
					 //    'model' => $searchModel,
					 //    'language' => 'ru',
					 //    // 'size' => 'lg',
					 //    'attribute' => 'delivery_date',
					 //    // 'template' => '{addon}{input}',
			   //      'clientOptions' => [
			   //          'autoclose' => false,
			   //          'format' => 'yyyy-mm-dd',
              			// 'clearBtn'=>true,
			   //      ]
						// ])
      //     ],
          [
            'format' => 'raw',
            'value' => function($model) {
                return Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                  ['view', 'id' => $model->id],['class' => 'btn btn-info']);                    
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
        'itemView' => 'payments_list',
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'news-item',
        ],
    ]);?>
    <?php endif;?>
	</div>
</div>

<?php
  if($toXls){
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
        [
          'attribute' => 'paymentStatus',
          'format' => 'raw',
          'value' => function ($model) {
            return Order::$statusesPayments[$model->status_payments];
          },
        ],

        'delivery_date',
      ]
    ]);    
  }
?>