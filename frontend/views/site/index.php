<?php

/* @var $this yii\web\View */

use yii\grid\GridView;

$this->title = "Главная";

echo Yii::$app->controller->layout;
?>
<div class="site-index">
    <div>
        <?= \common\widgets\ClientEndingProducts::widget(['client_id' => \Yii::$app->controller->client_id]) ?>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Ожидает отправку</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Последние доставки</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="messages">
                <?= GridView::widget([
                    'dataProvider' => $toDeliverProvider,
                    'filterModel' => $searchToDeliver,
                    'columns' => [
                        'created_at',
                        'city',
                        'address',
                        'client_name',
                        'phone',
                        'paymentType',
                        'price',

                        [
                            'attribute' => 'orderStatus',
                            'format' => 'raw'
                        ],

                        'delivery_date',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">
                <?= GridView::widget([
                    'dataProvider' => $deliveredProvider,
                    'filterModel' => $searchDelivered,
                    'columns' => [
//                        'number',
                        'created_at',
                        'city.title',
                        'address',
                        'client_name',
                        'phone',
                        'paymentType',
                        'price',

                        [
                            'attribute' => 'orderStatus',
                            'format' => 'raw'
                        ],

                        'delivery_date',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>

    </div>
</div>
