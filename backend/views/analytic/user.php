<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $dateFrom string
 * @var $dateTo string
 */

$this->title = "Отчет по менеджерам";
?>
<div class="row">
  <?= $this->render('_search_client_form'); ?>
  <?php $form = ActiveForm::begin(['method' => 'get']); ?>
  <div class="col-md-3">        
    <div class="btn-group btn-block">
        <?= $form->field($searchModel, 'dateFrom',['template'=>'{input}'])->widget(\dosamigos\datepicker\DateRangePicker::className(), [
          'attributeTo' => 'dateTo', 
          'form' => $form, // best for correct client validation
          'language' => 'ru',
          'labelTo' => 'До',
          // 'size' => 'lg',
          'clientOptions' => [
              'autoclose' => true,
              'format' => 'yyyy-mm-dd',
              'clearBtn'=>true,
              'toggleActive' => true,
          ]
        ]); ?>
    </div>
  </div>
  <div class="col-md-3">
    <div class="btn-group btn-block">
      <?= Html::button('<i class="glyphicon glyphicon-ok"></i> Сформулировать отчет', [
          'class' => 'btn btn-success btn-block',
          'type' => 'submit'
      ]) ?>
    </div>
  </div>
  <?php ActiveForm::end(); ?>  
</div>
<p></p>
<?= \common\widgets\PageViewContentForm::widget(['view'=> $view])?>
<p></p>
<?php if($view == 'table'):?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'username',
        [
            'attribute' => 'newOrderCount',
            'value' => function($model){
                return $model->getNewOrdersCount();
            }
        ],
        [
            'attribute' => 'workOrderCount',
            'value' => function($model){
                return $model->getWorkOrdersCount();
            }
        ],
        [
            'attribute' => 'completeOrderCount',
            'value' => function($model){
                return $model->getCompleteOrdersCount();
            }
        ],
        // 'created_at',
    ],
]); ?>
<?php else:?>
<?php $form = ActiveForm::begin(['method' => 'get','enableClientValidation' => false]); ?>
<p></p>
<div class="input-group">
  <?= $form->field($searchModel, 'username',['template'=>'{input}'])->textInput(['placeholder' => 'Искать по клиенту'])?>
  <span class="input-group-btn">
    <button class="btn btn-info" type="submit">Поиск</button>
  </span>
</div>
<?php ActiveForm::end(); ?> 
<?= ListView::widget([        
    'dataProvider' => $dataProvider,
    'itemView' => 'user_list',
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'news-item',
    ],
]);?>
<?php endif;?>