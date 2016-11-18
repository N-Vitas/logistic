<?php

use \common\models\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use yii\widgets\ListView;
use common\models\Product;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Доставка';
$this->params['breadcrumbs'][] = $this->title;
$radiolist = [
  'title' => 'По наименованию',
  'code_client' => 'По коду клиента',
  'barcode' => 'По артиклю',
  'nomenclature' => 'По номенклатуре'
];
$products = Product::find()
    ->where(['client_id' => Yii::$app->controller->client->is_id])
    ->asArray()
    ->all();
switch ($searchModel->filter) {
  case 'code_client':
    $placeholder[0] = 'Выберите код клиента';
    break;
  case 'barcode':
    $placeholder[0] = 'Выберите артикл';
    break;
  case 'nomenclature':
    $placeholder[0] = 'Выберите номенклатуру';
    break;
  
  default:
    $placeholder[0] = 'Выберите наименование';
    break;
}
ksort($placeholder);
?>

<div class="row"> 
  <?php $form = ActiveForm::begin(['method' => 'get']); ?>
  <div class="col-md-4">
    <div class="btn-group btn-block">
      <?= $form->field($searchModel, 'date_from',['template'=>'{input}'])->widget(DateRangePicker::className(), [
        'attributeTo' => 'date_to', 
        'form' => $form, // best for correct client validation
        'language' => 'ru',
        'labelTo' => 'До',
        // 'size' => 'lg',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'clearBtn'=>true,
            'toggleActive' => true,
        ]
      ]); ?>
    </div>
  </div>  
  <div class="col-md-4">
    <div class="btn-group btn-block">
        <?= Html::button('<i class="glyphicon glyphicon-ok"></i> Сформулировать отчет', [
            'class' => 'btn btn-success btn-block',
            'type' => 'submit'
        ]) ?>
    </div>
  </div>
  <div class="col-md-4">
    <div class="btn-group btn-block">
      <?= Html::a('Экспорт в XLS', [Url::current(['xls' => true])], ['class' => 'btn btn-info btn-block','target'=>'_blank']) ?>
    </div>
  <?php ActiveForm::end(); ?> 
  </div>  
</div>
<p></p>
<?= \common\widgets\DeliveryStatus::widget(['client_id' => \Yii::$app->user->getIdentity()->client_id]) ?>
<div class="row">
  <?php $form = ActiveForm::begin(['method' => 'get']); ?>
  <div class="col-md-12">
      <div class="btn-group btn-block">
        <?= $form->field($searchModel, 'filter',['template'=>'{label}{input}'])->dropDownList($radiolist, ['class' => 'form-control','id'=>'change', 'onchange'=>'this.form.submit()']); ?>
      </div>
      <div class="btn-group btn-block">
        <?= $form->field($searchModel, 'product_id',['template'=>'{label}{input}'])
          ->widget(Select2::className(), [
            'data' => ArrayHelper::map($products, 'id', $searchModel->filter),
            'options' => [
                'placeholder' => 'Выберите продукт',
                'multiple' => true,
            ],
            'pluginOptions' => [
              'allowClear' => true,
            ],            
          ]);
        ?>
      </div>           
  </div>
  <div class="col-md-4">
  </div>
  <?php ActiveForm::end(); ?>  
</div>
<p></p>
<?= \common\widgets\PageViewContentForm::widget(['view'=> $view])?>
<div class="row">
  <div class="col-md-12">
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
        'itemView' => 'delivery_list',
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