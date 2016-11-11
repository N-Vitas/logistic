<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $dateFrom string
 * @var $dateTo string
 */

$this->title = "Отчет по менеджерам";
?>
<div class="row">
  <?php $form = ActiveForm::begin(['method' => 'get']); ?>
  <div class="col-md-3">         
    <div class="btn-group btn-block">
      <?= Html::a('< Назад', ['/user'], ['class' => 'btn btn-info btn-block']) ?>
    </div> 
  </div>
  <div class="col-md-3">         
    <div class="btn-group btn-block">
        <?= \dosamigos\datepicker\DateRangePicker::widget([
            'name' => 'dateFrom',
            'value' => !empty($dateFrom) ? $dateFrom : "",
            'nameTo' => 'dateTo',
            'valueTo' => !empty($dateTo) ? $dateTo : "",
            'labelTo' => 'До',
            'language' => 'ru',
            'clientOptions' => [
                'autoclose' => true,
                'clearBtn'=>true,
                'format' => 'yyyy-mm-dd',
            ],
        ]); ?>
    </div>
  </div>
  <div class="col-md-3">
    <div class="btn-group btn-block">
      <?= Html::button('<i class="glyphicon glyphicon-ok"></i> Сформулировать отчет', [
          'class' => 'btn btn-success btn-block',
          'type' => 'submit'
      ]) ?>
    </div>
  </div>
  <div class="col-md-3">         
    <div class="btn-group btn-block">
      <?= Html::a('Экспорт в XLS', [Url::current(['xls' => true])], ['class' => 'btn btn-info btn-block','target'=>'_blank']) ?>
    </div> 
  </div>
  <?php ActiveForm::end(); ?>  
</div>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'username',
        [
            'attribute' => 'newOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getNewOrdersCount($dateFrom, $dateTo);
            }
        ],
        [
            'attribute' => 'workOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getWorkOrdersCount($dateFrom, $dateTo);
            }
        ],
        [
            'attribute' => 'completeOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getCompleteOrdersCount($dateFrom, $dateTo);
            }
        ],
        // 'created_at',
    ],
]); ?>