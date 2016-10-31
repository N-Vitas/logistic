<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \dosamigos\datepicker\DateRangePicker;
use \dosamigos\datepicker\DatePicker;
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = "Отчет по остаткам";
?>

<div class="row">
  <?php $form = ActiveForm::begin(['method' => 'get']); ?>
  <?php if($searchModel->groups):?>
  <div class="col-md-2">
    <div class="btn-group btn-block">
      <?= Html::button('<i class="glyphicon glyphicon-list"></i> Разгруппировать', [
          'class' => 'btn btn-warning btn-block',
          'name' => 'ProductAnalyzeSearch[groups]',
          'value' => 0,
          'type' => 'submit'
      ]) ?>
    </div>
  </div>
  <?php else:?>
  <div class="col-md-2">
    <div class="btn-group btn-block">
      <?= Html::button('<i class="glyphicon glyphicon-list"></i> Сгруппировать', [
          'class' => 'btn btn-success btn-block',
          'name' => 'ProductAnalyzeSearch[groups]',
          'value' => 1,
          'type' => 'submit'
      ]) ?>
    </div>
  </div>
  <?php endif;?>
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
  <div class="col-md-2">
    <div class="btn-group btn-block">
      <?= Html::button('<i class="glyphicon glyphicon-refresh"></i> Сбросить перриод', [
          'class' => 'btn btn-success btn-block',
          'type' => 'button',
          'onClick' => 'jQuery("#productanalyzesearch-date_from,#productanalyzesearch-date_to").val("");this.form.submit()',
      ]) ?>
    </div>
  </div>
  <div class="col-md-2">
    <div class="btn-group btn-block">
      <?= Html::button('<i class="glyphicon glyphicon-ok"></i> Сформулировать отчет', [
          'class' => 'btn btn-success btn-block',
          'type' => 'submit'
      ]) ?>
    </div>
  </div>
  <div class="col-md-2">         
    <div class="btn-group btn-block">
      <?= Html::a('Экспорт в XLS', [Url::current(['xls' => true])], ['class' => 'btn btn-info btn-block','target'=>'_blank']) ?>
    </div> 
  </div>
  <?php ActiveForm::end(); ?>  
</div>
<div class="row">
  <div class="col-md-12">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
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
        'increase',
        'decrease',
      ]
    ]); ?>        
  </div>
</div>
