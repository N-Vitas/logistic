<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = 'Новый клиент';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user
    ]) ?>

</div>
