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
use yii\widgets\ActiveForm;
use common\models\Product;

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
$placeholder = ArrayHelper::map($products, 'id', $filterModel->filter);
switch ($filterModel->filter) {
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

$script = <<< JS
jQuery(document).ready(function() {
  $('#add-product').click(function(){
    alert($filterModel->product_id = $('#product :selected').val())
    if (productId && !productIds[productId]) {
        $('.no-products').addClass('hidden');
        productIds[productId] = productId;
  });
});
JS;
$this->registerJs($script);
?>
<?php Pjax::begin(); ?>
<div class="row">
  <?php $form = ActiveForm::begin(['method' => 'get']); ?>
  <div class="col-md-8">
      <div class="btn-group">
        <?= $form->field($filterModel, 'filter',['template'=>'{input}'])->dropDownList($radiolist, ['class' => 'form-control','id'=>'change', 'onchange'=>'this.form.submit()']); ?>
      </div>
      <div class="btn-group">
        <?= $form->field($filterModel, 'product_id',['template'=>'{input}'])->dropDownList($placeholder, ['class' => 'form-control','id'=>'product']); ?>
      </div>   
      <div class="btn-group pull-right">
          <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Добавить', [
              'class' => 'btn btn-success btn-block add-product',
              'id' => 'add-product',
              'type' => 'submit'
          ]) ?>          
      </div>           
  </div>
  <div class="col-md-4">
      <div class="btn-group pull-right">
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
      <div class="btn-group pull-right">
          <?= Html::button('<i class="glyphicon glyphicon-ok"></i> Сформулировать отчет', [
              'class' => 'btn btn-success btn-block',
              'type' => 'submit'
          ]) ?>
          <?= Html::a('Экспорт в XLS', [Url::current(['xls' => true])], ['class' => 'btn btn-info btn-block']) ?>
      </div>   
  </div>
  <?php ActiveForm::end(); ?>  
</div>
<?php Pjax::end(); ?>