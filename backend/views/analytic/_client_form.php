<?php $action = empty($action) ? ['analyze/user'] : $action ?>

<?php \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::current(),
]) ?>
<h4>Клиент:</h4>
<div class="row">
    <div class="col-md-4">
        <?= \yii\helpers\Html::dropDownList('client_id', \Yii::$app->controller->client_id, \Yii::$app->controller->clients, [
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-md-2">
        <?= \yii\helpers\Html::button('Применить', ['class' => 'btn btn-success btn-block', 'type' => 'submit']) ?>
    </div>
    <div class="col-md-6">
    </div>
</div>
<?php \yii\widgets\ActiveForm::end() ?>

<hr>
<?php $action = empty($action) ? ['analyze/user'] : $action ?>
