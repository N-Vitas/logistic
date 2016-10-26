<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="pull-right">
        <?= Html::a('Отчет по платежам', ['/analytic/payments'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отчет по доставкам', ['/analytic/delivery'], ['class' => 'btn btn-success']) ?>
    </div>

    <p>
        <?= Html::a('Оформить заказ на доставку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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

            [
                'format' => 'raw',
                'value' => function($model) {
                    $activeCancel = true;
                    if ((strtotime($model->created_at) - time()) > 15 * 60 || $model->status == $model::STATUS_CANCELED)
                        $activeCancel = false;

                    $cancelButton = Html::a('<i class="glyphicon glyphicon-trash"></i>',
                        ['cancel', 'id' => $model->id], [
                        'class' => 'btn btn-danger' . ($activeCancel ? ' disabled' : ''),
                        'data' => [
                            'confirm' => 'Вы точно хотите отменить заказ?',
                            'method' => 'post',
                        ],
                    ]);

                    $viewButton = Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                        ['view', 'id' => $model->id], [
                        'class' => 'btn btn-info'
                    ]);
                    return $cancelButton . $viewButton;
                }
            ]
        ],
    ]); ?>

</div>
