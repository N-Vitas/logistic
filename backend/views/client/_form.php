<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'legal_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?php if ($model->isNewRecord && !empty($user)) : ?>
        <h3>Администратор клиента</h3>

        <?= $form->field($user, 'username')->textInput() ?>
        <?= $form->field($user, 'email')->textInput() ?>
        <?= $form->field($user, 'password')->passwordInput() ?>
    <?php endif ?>
    
    <?php if (!$model->isNewRecord): ?>

        <h4>О компании:</h4>
        <hr>
        
        <?= $form->field($settingsModel, 'address')->textInput() ?>
        <?= $form->field($settingsModel, 'phone')->textInput() ?>
        <?= $form->field($settingsModel, 'email')->textInput() ?>

    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
