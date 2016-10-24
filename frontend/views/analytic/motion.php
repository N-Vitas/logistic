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

<?= \common\widgets\FilterDateRangeForm::widget(['filterModel' => $searchModel]) ?>
<div class="row">
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
    ]); ?>        
  </div>
</div>
