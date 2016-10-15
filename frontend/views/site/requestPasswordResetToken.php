<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Форма востановления пароля';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="login-box">
    <?= \common\widgets\Alert::widget(); ?>
    <div class="login-logo">
        <a href="#"><b>Cabinet</b>Clicklog</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Восстановление пароля</p>

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <a href="/site/login" class="btn btn-primary btn-block btn-flat">Вернуться назад</a>
                </div>
                <!-- /.col -->
            </div>

        <?php ActiveForm::end(); ?>



    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->