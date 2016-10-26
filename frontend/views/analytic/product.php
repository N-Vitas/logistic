<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Остаток на складе';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
<div class="row">
      <div class="col-md-2">         
        <div class="btn-group btn-block">
          <?= Html::a('< Назад', ['/product'], ['class' => 'btn btn-info btn-block']) ?>
        </div> 
      </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => array_merge(
            array_merge([['class' => 'yii\grid\SerialColumn'], 'title'], $columns),
            [
                'nomenclature',
                'balance',
            ]
        )
    ]); ?>

</div>
