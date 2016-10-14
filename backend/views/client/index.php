<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый клиент', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'legal_name',
            [
                'attribute' => 'productCount',
                'value' => function($model) {
                    return \common\models\Product::find()->where(['client_id' => $model->is_id])
                        ->count();
                }
            ],
            'settings.phone',
            'settings.email',
//            'admin.username',
            [
                'attribute' => 'activeOrders',
                'value' => function($model) {
                    return \common\models\Order::find()
                        ->where(['client_id' => $model->id])
                        ->andWhere(['in', 'status', \common\models\Order::$activeStatuses])
                        ->count();
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>

</div>
