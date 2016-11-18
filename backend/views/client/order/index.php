<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы клиента на доставку ' . $client->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Html::a(
        '<i class="glyphicon glyphicon-chevron-left"></i> Вернуться в карточку клиента',
        ['client/view', 'id' => $client->id],
        ['class' => 'btn btn-success']
    ) ?>

    <div class="pull-right" style="margin-bottom: 15px;">
        <?= Html::a('Отчет по платежам', ['/analytic/payments'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отчет по доставкам', ['/analytic/delivery'], ['class' => 'btn btn-success']) ?>
    </div>

    <hr style="clear: both;">

    <div class="row">
        <div class="col-md-4">
            <div class="alert alert-info">
                <h4><i class="fa fa-calendar"></i> Доставлено вчера</h4>
                <h2><?= $deliveredYesterday ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-success">
                <h4><i class="fa fa-check"></i> Доставлено сегодня</h4>
                <h2><?= $deliveredToday ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-warning">
                <h4><i class="fa fa-clock-o"></i> Ожидает доставки</h4>
                <h2><?= $toDeliver ?></h2>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'created_at',
            'city.title',
            'address',
            'client_name',
            'phone',
            // 'product_id',
            // 'email:email',
            'paymentType',
            'price',

            [
                'attribute' => 'orderStatus',
                'format' => 'raw',
            ],

            'delivery_date',

            
        ],
    ]); ?>

</div>
