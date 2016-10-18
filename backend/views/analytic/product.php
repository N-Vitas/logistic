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
      <div class="col-md-12">
      <?= $this->render('_search_client_form'); ?>
      </div>
      <div class="col-md-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                  'value' => 'product.title',
                  'attribute' => 'product_title'
                ],
                [
                  'value' => 'product.nomenclature',
                  'attribute' => 'product_nomenclature'
                ],
                [
                  'value' => 'product.code_client',
                  'attribute' => 'product_code_client'
                ],
                [
                  'value' => 'product.barcode',
                  'attribute' => 'product_barcode'
                ],
                [
                  'value' => 'product.balance',
                  'attribute' => 'product_balance'
                ],
            ]
        ]); ?>
      </div>
    </div>
</div>
