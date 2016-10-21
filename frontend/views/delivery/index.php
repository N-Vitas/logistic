<?php

use \common\models\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\widgets\Pjax;

$this->title = 'Доставка';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \common\widgets\DeliveryStatus::widget(['client_id' => \Yii::$app->user->getIdentity()->client_id]) ?>
<?= \common\widgets\FilterForm::widget(['filterModel' => $searchModel]) ?>
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
      ]
    ]);    
  }
?>
<div class="row">
	<div class="col-md-12">
	<?php Pjax::begin(); ?>
		<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'tableOptions' => [
          'class' => 'table table-striped table-bordered'
      ],
      'columns' => [
          [
          	'attribute' => 'id',
          	'contentOptions' =>['class' => 'table_class','style'=>'width:10px;'],
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
			            'autoclose' => false,
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
	        [
            'attribute' => 'paymentType',
            'format' => 'raw',
            // 'value' => function($model) {
            //     return $model->getOrderStatus();
            // },
            'filter' => Html::activeDropDownList($searchModel, 'payment_type', Order::$paymentTypes,['class' => 'form-control']),
	        ],
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
		<?php Pjax::end(); ?>
	</div>
</div>