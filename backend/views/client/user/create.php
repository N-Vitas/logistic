<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $model common\models\Client */

$this->title = 'Добавить пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['client/index']];
$this->params['breadcrumbs'][] = ['label' => $client->name, 'url' => ['client/view', 'id' => $client->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
