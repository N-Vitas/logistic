<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NotificationSettings */

$this->title = 'Настройки уведомлений';
$this->params['breadcrumbs'][] = ['label' => 'Notification Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-settings-create">

    <?= $this->render('_form', [
        'model' => $model,
        'client' => $client,
    ]) ?>

</div>
