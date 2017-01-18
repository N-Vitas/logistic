<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Client;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = "Заказ на доставку № $model->id";
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$client = Client::find()->where(['is_id'=>$model->client_id])->one();
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Вернуться к заказам', '/client/orders?id='.$client->id, ['class' => 'btn btn-info','style'=>'margin-bottom: 17px;'])?> 

    

    <table id="w0" class="table table-striped table-bordered detail-view">
        <tbody>
            <tr><th><?=$model->getAttributeLabel('id')?></th><td><?=sprintf("%09d", $model->id)?></td></tr>
            <tr><th><?=$model->getAttributeLabel('created_at')?></th><td><?=$model->created_at?></td></tr>
            <tr><th><?=$model->getAttributeLabel('client_name')?></th><td><?=$model->client_name?></td></tr>
            <tr><th><?=$model->getAttributeLabel('city.title')?></th><td><?=$model->city->title?></td></tr>
            <tr><th><?=$model->getAttributeLabel('address')?></th><td><?=$model->address?></td></tr>
            <tr><th><?=$model->getAttributeLabel('phone')?></th><td><?=$model->phone?></td></tr>
            <tr><th><?=$model->getAttributeLabel('email')?></th><td><a href="mailto:<?=$model->email?>"><?=$model->email?></a></td></tr>
            <tr><th><?=$model->getAttributeLabel('paymentType')?></th><td><?=$model->paymentType?></td></tr>
            <tr><th><?=$model->getAttributeLabel('price')?></th><td><?=$model->price?></td></tr>
            <tr><th><?=$model->getAttributeLabel('comment')?></th><td><?=$model->comment?></td></tr>
        </tbody>
    </table>

    <?php /* DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',  
            'created_at',
            // 'client_id',
            'client_name',
            'city.title',
            'address',
            'phone',
            'email:email',
            'paymentType',
            'price',
            'comment',
        ],
    ]) */ ?>

    <h2>Наименования в заказе</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($model->items as $item): ?>
            <tr>
                <td><?= $item->product->title ?></td>
                <td><?= $item->price ?></td>
                <td><?= $item->quantity ?></td>
                <td><?= $item->quantity*$item->price ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
