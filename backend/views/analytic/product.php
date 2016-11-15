<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Остаток на складе';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="row">
      <div class="col-md-12">
      <?= $this->render('_client_form'); ?>
      </div>
      <div class="col-md-12">      
        <?= \common\widgets\PageViewContentForm::widget(['view'=> $view])?>
      </div>
      <div class="col-md-12">
        <?php if($view == 'table'):?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title', 
                'article', 
                'barcode', 
                'code_client',
                'nomenclature', 
                'balance'
                // [
                //   'value' => 'product.title',
                //   'attribute' => 'product_title'
                // ],
                // [
                //   'value' => 'product.nomenclature',
                //   'attribute' => 'product_nomenclature'
                // ],
                // [
                //   'value' => 'product.code_client',
                //   'attribute' => 'product_code_client'
                // ],
                // [
                //   'value' => 'product.barcode',
                //   'attribute' => 'product_barcode'
                // ],
                // [
                //   'value' => 'product.balance',
                //   'attribute' => 'product_balance'
                // ],
            ]
        ]); ?>
        <?php else:?>
        <?php $form = ActiveForm::begin(['method' => 'get']); ?>
        <p></p>
        <div class="input-group">
          <?= $form->field($searchModel, 'title',['template'=>'{input}'])->textInput(['placeholder' => 'Искать по наименованию'])?>
          <span class="input-group-btn">
            <button class="btn btn-info" type="button">Поиск</button>
          </span>
        </div>
        <?php ActiveForm::end(); ?> 
        <?= ListView::widget([        
            'dataProvider' => $dataProvider,
            'itemView' => 'product_list',
            'itemOptions' => [
                'tag' => 'div',
                'class' => 'news-item',
            ],
        ]);?>
        <?php endif;?>
      </div>
    </div>
</div>
