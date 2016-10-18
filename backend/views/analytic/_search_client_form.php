<?php $action = empty($action) ? ['analyze/user'] : $action ?>

<?php \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::current(),
]) ?>
<div class="btn-group">
	<span class="form-control">Клиент :</span>
</div>
<div class="btn-group">
  <?= \yii\helpers\Html::dropDownList('client_id', \Yii::$app->controller->client_id, \Yii::$app->controller->clients, [
      'class' => 'form-control'
  ]) ?>
</div>
<div class="btn-group">
        <?= \yii\helpers\Html::button('Применить', ['class' => 'btn btn-success', 'type' => 'submit']) ?>
</div>
<?php \yii\widgets\ActiveForm::end() ?>
