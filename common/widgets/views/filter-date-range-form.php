<?php
/**
 * @var $endingProducts \common\models\Product[]
 * @var $endedProducts \common\models\Product[]
 */
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DateRangePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use common\models\Product;
use yii\web\JsExpression;

?>
<?php ////Pjax::begin(); ?>
<div class="row">
  <?php $form = ActiveForm::begin(['method' => 'get']); ?>
  <div class="col-md-4">         
    <div class="btn-group btn-block">
      <?= $form->field($filterModel, 'date_from',['template'=>'{input}'])->widget(DateRangePicker::className(), [
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
  </div>
  <?php ActiveForm::end(); ?>  
</div>
<?php //Pjax::end(); ?>