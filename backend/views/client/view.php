<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = 'Информация по клиенту: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="client-view">
  <div class="row">
    <div class="col-md-5">
      <div class="row">
        <div class="col-md-4">
          <?= Html::a('< Назад', ['index'], ['class' => 'btn btn-block btn-warning']) ?>          
        </div>
        <div class="col-md-4">          
          <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-block btn-primary']) ?>
        </div>
        <div class="col-md-4">
          <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
              'class' => 'btn btn-block btn-danger',
              'data' => [
                  'confirm' => 'Вы точно хотите удалить этого клиента?',
                  'method' => 'post',
              ],
          ]) ?>          
        </div>
        <div class="col-md-12">
          <?= DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'legal_name',
                  'is_id',
                  'name',
                  'settings.phone',
                  'settings.email',
                  'settings.address',
                  'created_at',
              ],
          ]) ?>          
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="row">
        <div class="col-md-6">
          <?= Html::a('Остатки клиента на складе', ['products', 'id' => $model->id], ['class' => 'btn btn-block btn-primary' . ($activeProducts == 0 ? ' disabled' : '')]) ?>          
        </div>
        <div class="col-md-6">
          <?= Html::a('Заказы клиента на доставку', ['orders', 'id' => $model->id], ['class' => 'btn btn-block btn-info' ]) ?>
        </div>
        <div class="col-md-12">
          <h4>Остатки на складе</h4>
          <?= \common\widgets\ClientEndingProducts::widget(['client' => $model]) ?>          
        </div>
      </div>
    </div>
  </div>
  <h3>Администраторы и менеджеры клиента</h3>
  <?= Html::a('Добавить', ['create-user', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

  <hr>

  <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $clientUsers,
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],

          'username',
          'email:email',
          [
              'attribute' => 'role',
              'value' => function ($data) {
                  /* @var $data \backend\models\ClientUser */
                  return $data->userRoles;
              }
          ],
          [
              'value' => function ($data) {
                  return
                      '<div class="btn-group">' .
                      Html::a('<i class="glyphicon glyphicon-edit"></i>',
                          ['client/update-user', 'id' => $_GET['id'], 'user_id' => $data->id],
                          ['class' => 'btn btn-warning btn-xs']) .
                      Html::a('<i class="glyphicon glyphicon-trash"></i>',
                          ['client/delete-user', 'id' => $_GET['id'], 'user_id' => $data->id], [
                          'class' => 'btn btn-danger btn-xs',
                          'data' => [
                              'confirm' => 'Вы точно хотите удалить этого пользователя?',
                              'method' => 'post',
                          ],
                      ]) .
                      '</div>';
              },
              'format' => 'raw'
          ],
      ],
  ]); ?>
</div>
