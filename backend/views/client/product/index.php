<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $client \common\models\Client */

$this->title = 'Остатки на складе клиента ' . $client->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $client->name, 'url' => ['view', 'id' => $client->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <?= Html::a('< Вернуться в карточку клиента', ['view', 'id' => $client->id], ['class' => 'btn btn-success']) ?>

    <hr>

    <?= \common\widgets\ClientEndingProducts::widget(['client' => $client]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => array_merge(
            array_merge([['class' => 'yii\grid\SerialColumn'], 'title'], $columns),
            [
                'nomenclature',
                'balance',
            ]
        ),
    ]); ?>

</div>
