<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$atributes = $model->attributeLabels();
// $balance = $model->getBalance()->one();
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <table id="w0" class="table table-striped table-bordered detail-view">
      <tbody>
        <tr><th><?= $atributes['id'] ?></th><td><?= $model->id ?></td></tr>
        <tr><th><?= $atributes['title'] ?></th><td><?= $model->title ?></td></tr>
        <tr><th><?= $atributes['article'] ?></th><td><?= $model->article ?></td></tr>
        <tr><th><?= $atributes['barcode'] ?></th><td><?= $model->barcode ?></td></tr>
        <tr><th><?= $atributes['code_client'] ?></th><td><?= $model->code_client ?></td></tr>
        <tr><th><?= $atributes['balance'] ?></th><td><?= $model->balance ?></td></tr>
        <tr><th><?= $atributes['updated_at'] ?></th><td><?= $model->updated_at ?></td></tr>
        <?php
          if($balance){
            $label = $balance->attributeLabels();
            echo "<tr><th>$label[min_balance]</th><td>$balance->min_balance <button type='button' class='btn btn-success pull-right' data-toggle='modal' data-target='#myModal'><i class='glyphicon glyphicon-pencil'></i></button></td></tr>";
          } 
        ?>
      </tbody>
    </table>    
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">            
            <?php 
            $form = ActiveForm::begin([
              // 'action' => ['index'],
              'method' => 'post',
            ]); 
            ?>
            <?= $form->field($balance, 'min_balance') ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
          </div>
            <?php ActiveForm::end();?>
        </div>
      </div>
    </div>

</div>