<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\tagsinput\TagsinputWidget;

/* @var $this yii\web\View */
/* @var $model common\models\NotificationSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-settings-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php empty($model->errors) ? $tagClass = 'label label-success' : $tagClass = 'label label-danger';?>
    <?php if (\Yii::$app->user->can('createClientManager')) : ?>
        <?php //$form->field($model, 'low_products')->textInput() ?>
        <div class="btn-block">
            <?= $form->field($model, 'emails')->widget(TagsinputWidget::classname(), [
                'clientOptions' => [
                    'trimValue' => true,
                    'allowDuplicates' => false,
                    'tagClass' => $tagClass,
                    // 'focusClass' => 'form-control',
                ],
                'options'=>['class'=>'form-control']
            ])/*->textarea(['rows' => 6])*/ ?>            
        </div>

        <?= $form->field($model, 'client_notification')->checkbox() ?>

        <?= $form->field($model, 'client_complete_notification')->checkbox() ?>

        <h4>О компании <?= $client->name ?>:</h4>
        <hr>

        <?= $form->field($model, 'address')->textInput() ?>
        <?= $form->field($model, 'phone')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
    <?php endif ?>


    <h4>Вывести в остатках:</h4>
    <hr>

    <?= $form->field($model, 'show_article')->checkbox() ?>
    <?= $form->field($model, 'show_barcode')->checkbox() ?>
    <?= $form->field($model, 'show_code_client')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
