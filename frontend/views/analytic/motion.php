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
  <div class="col-md-12">
    <div class="btn-toolbar" role="toolbar">
      <div class="btn-group">
        <?= Html::a('< Назад', ['/product'], ['class' => 'btn btn-info']) ?>        
      </div>
      <?php ActiveForm::begin([
          'method' => 'get',
          // navbar-form navbar-left
          // 'action' => Url::to(['analyze/product'])
      ]) ?>
      <div class="btn-group pull-right">
        <?= Html::button('<i class="glyphicon glyphicon-ok"></i> Сформулировать отчет', [
            'class' => 'btn btn-success',
            'type' => 'submit'
        ]) ?>        
      </div>
      <div class="btn-group pull-right">
          <?= DateRangePicker::widget([
              'name' => 'dateFrom',
              'value' => !empty($dateFrom) ? $dateFrom : date('Y-m-01'),
              'nameTo' => 'dateTo',
              'valueTo' => !empty($dateTo) ? $dateTo : date('Y-m-d'),
              'labelTo' => 'До',
              'clientOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
              ],
          ]); ?>
      </div>
      <div class="btn-group pull-right">
        <?= Html::a('Экспорт в XLS', [Url::current(['xls' => true])], ['class' => 'btn btn-info']) ?>
      </div>
      <?php ActiveForm::end() ?>
    </div>
  </div>
  <hr/>
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
        'increase',
        'decrease',
      ]
    ]); ?>        
  </div>
</div>
