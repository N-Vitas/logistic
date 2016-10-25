<?php

/* @var $this yii\web\View */

use \common\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

$this->title = "Главная";
?>
<div class="site-index">
    <div>
        <?= \common\widgets\ClientEndingProducts::widget(['client_id' => \Yii::$app->controller->client_id]) ?>

        <?= \common\widgets\DeliveryStatus::widget(['client_id' => \Yii::$app->controller->client_id]) ?>

        <?= \common\widgets\PaymentsStatus::widget(['client_id' => \Yii::$app->controller->client_id]) ?>
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
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
          [
            'attribute' => 'id',
            'contentOptions' =>['class' => 'table_class','style'=>'width:10px;'],
          ],
          [
            'attribute' => 'created_at',
            // 'format' => 'raw',
            'value' => 'created_at',
            'filter' => DatePicker::widget([
                        'model' => $searchToDeliver,
                        'language' => 'ru',
                        // 'size' => 'lg',
                        'attribute' => 'created_at',
                        // 'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    'clearBtn'=>true,
                    ]
                        ])
          ],
          [
            'attribute' => 'city.title',
            'format' => 'raw',
            'filter' => Html::activeInput('text', $searchToDeliver, 'city', ['class' => 'form-control'])
          ],
          'address',
          'client_name',
          'phone',
          // 'product_id',
          // 'email:email',,
            [
            'attribute' => 'paymentType',
            'format' => 'raw',
            // 'value' => function($model) {
            //     return $model->getOrderStatus();
            // },
            'filter' => Html::activeDropDownList($searchToDeliver, 'payment_type', Order::$paymentTypes,['class' => 'form-control']),
            ],
          // 'paymentType',
          'price',
            [
            'attribute' => 'orderStatus',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getOrderStatus();
            },
            'filter' => \yii\bootstrap\Html::activeDropDownList($searchToDeliver, 'orderStatus', Order::$statuses,['class' => 'form-control']),
            ],
            [
              'format' => 'raw',
              'value' => function($model) {
                  return Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                    ['view', 'id' => $model->id],['class' => 'btn btn-info']);                    
              }
            ],
            [
           'attribute' => 'delivery_date',
           // 'format' => 'raw',
            'value' => 'delivery_date',
            'filter' => DatePicker::widget([
              'model' => $searchToDeliver,
              'language' => 'ru',
              // 'size' => 'lg',
              'attribute' => 'delivery_date',
              // 'template' => '{addon}{input}',
              'clientOptions' => [
                  'autoclose' => false,
                  'format' => 'yyyy-mm-dd',
                    'clearBtn'=>true,
              ]
            ])
          ],
        ],
    ]); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">
              <?= GridView::widget([
                'dataProvider' => $deliveredProvider,
                'filterModel' => $searchDelivered,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered'
                ],
                'columns' => [
                  [
                    'attribute' => 'id',
                    'contentOptions' =>['class' => 'table_class','style'=>'width:10px;'],
                  ],
                  [
                    'attribute' => 'created_at',
                    // 'format' => 'raw',
                    'value' => 'created_at',
                    'filter' => DatePicker::widget([
                                'model' => $searchDelivered,
                                'language' => 'ru',
                                // 'size' => 'lg',
                                'attribute' => 'created_at',
                                // 'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            'clearBtn'=>true,
                            ]
                                ])
                  ],
                  [
                    'attribute' => 'city.title',
                    'format' => 'raw',
                    'filter' => Html::activeInput('text', $searchDelivered, 'city', ['class' => 'form-control'])
                  ],
                  'address',
                  'client_name',
                  'phone',
                  // 'product_id',
                  // 'email:email',,
                    [
                    'attribute' => 'paymentType',
                    'format' => 'raw',
                    // 'value' => function($model) {
                    //     return $model->getOrderStatus();
                    // },
                    'filter' => Html::activeDropDownList($searchDelivered, 'payment_type', Order::$paymentTypes,['class' => 'form-control']),
                    ],
                  // 'paymentType',
                  'price',
                    [
                    'attribute' => 'orderStatus',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->getOrderStatus();
                    },
                    'filter' => \yii\bootstrap\Html::activeDropDownList($searchDelivered, 'orderStatus', Order::$statuses,['class' => 'form-control']),
                    ],
                    [
                   'attribute' => 'delivery_date',
                   // 'format' => 'raw',
                    'value' => 'delivery_date',
                    'filter' => DatePicker::widget([
                      'model' => $searchDelivered,
                      'language' => 'ru',
                      // 'size' => 'lg',
                      'attribute' => 'delivery_date',
                      // 'template' => '{addon}{input}',
                      'clientOptions' => [
                          'autoclose' => false,
                          'format' => 'yyyy-mm-dd',
                            'clearBtn'=>true,
                      ]
                    ])
                  ],
                    [
                      'format' => 'raw',
                      'value' => function($model) {
                          return Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                            ['view', 'id' => $model->id],['class' => 'btn btn-info']);                    
                      }
                    ],
                ],
            ]); ?>
            </div>
        </div>

    </div>
</div>
