<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
             'email:email',
            [
                'attribute' => 'role',
                'value' => function ($data) {
                    /* @var $data \backend\models\ClientUser */
                    return $data->userRoles;
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model) {
                    return date('Y-m-d', $model->created_at);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    /* @var $model \frontend\models\UserSearch */
                    return \common\models\User::$statuses[$model->status];
                },

            ],
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'
            ],
        ],
    ]); ?>

</div>
