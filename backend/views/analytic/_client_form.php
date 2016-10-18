<?php $action = empty($action) ? ['analyze/user'] : $action ?>

<?php \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::current(),
]) ?>
<h4>Клиент:</h4>
<div class="row">
    <div class="col-md-6">
        <?= \yii\helpers\Html::dropDownList('client_id', \Yii::$app->controller->client_id, \Yii::$app->controller->clients, [
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-md-3">
        <?= \yii\helpers\Html::button('Применить', ['class' => 'btn btn-success', 'type' => 'submit']) ?>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end() ?>

<hr>
