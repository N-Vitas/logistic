<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Мой профиль';
$this->params['breadcrumbs'][] = 'Профиль';
?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
        'profile' => true,
    ]) ?>

</div>
