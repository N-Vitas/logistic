<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ClientUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-8">
            <h2>Общая информация</h2>
            <hr>

            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>

            <?= $form->field($model, 'imageFile')->fileInput() ?>

            <?php if (!isset($profile)) : ?>
                <?= $form->field($model, 'status')->dropDownList(\common\models\User::$statuses) ?>
                <?= $form->field($model, 'client_id', ['template' => '{input}'])->hiddenInput() ?>
                <?= $form->field($model, 'role')->dropDownList($model::$roles) ?>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <h2><?= $model->isNewRecord ? 'Пароль' : 'Смена пароля' ?></h2>
            <hr>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'passwordCompare')->passwordInput() ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
