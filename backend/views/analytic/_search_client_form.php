<?php $action = empty($action) ? ['analyze/user'] : $action ?>

<?php \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::current(),
]) ?>

<div class="col-md-4">
	<div class="btn-group btn-block">
	  <?= \yii\helpers\Html::dropDownList('client_id', \Yii::$app->controller->client_id, \Yii::$app->controller->clients, [
	      'class' => 'form-control'
	  ]) ?>
	</div>
</div>
<div class="col-md-2">
	<div class="btn-group btn-block">
	        <?= \yii\helpers\Html::button('Применить', ['class' => 'btn btn-success btn-block', 'type' => 'submit']) ?>
	</div>
</div>
<?php \yii\widgets\ActiveForm::end() ?>
