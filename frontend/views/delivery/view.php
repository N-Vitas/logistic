<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = "Заказ на доставку № = $model->id";
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'client_id',
            'client_name',
            'city.title',
            'address',
            'phone',
            'email:email',
            'paymentType',
            'price',
            'comment',
        ],
    ]) ?>

    <h2>Наименования в заказе</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Кол-во</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($model->items as $item): ?>
            <tr>
                <td><?= $item->product->title ?></td>
                <td><?= $item->price ?></td>
                <td><?= $item->quantity ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
