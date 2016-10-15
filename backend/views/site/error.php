<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<? if(\Yii::$app->user->identity):?>
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>
        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>
    </div>
<? else:?>
  <div class="login-box">
    <?= \common\widgets\Alert::widget(); ?>
    <div class="login-logo">
        <a href="#"><b>Cabinet</b>Clicklog</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="box box-solid box-danger">
          <div class="box-header">
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
              <a class="btn btn-danger pull-right" href="/">Назад</a>
          </div><!-- /.box-header -->
          <div class="box-body">
            <?= nl2br(Html::encode($message)) ?>
          </div><!-- /.box-body -->
        </div>
    </div>
  </div><!-- /.login-box -->
<? endif;?>
