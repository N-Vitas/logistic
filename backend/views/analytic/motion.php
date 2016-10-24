<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \dosamigos\datepicker\DateRangePicker;
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = "Отчет по остаткам";
?>
<div class="row">
  <div class="col-md-12">
      <?= $this->render('_client_form'); ?>
  </div>
  <div class="col-md-12">
  <?= \common\widgets\FilterDateRangeForm::widget(['filterModel' => $searchModel,'export'=>false]) ?>
  </div>
  <div class="col-md-12">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
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
        // 'created_at',
        'increase',
        'decrease',
      ]
    ]); ?>        
  </div>
</div>
