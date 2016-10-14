<?php
use yii\grid\GridView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = "Отчет по остаткам";
?>

<?= $this->render('_client_form'); ?>

    <div class="pull-right">
        <?php \yii\widgets\ActiveForm::begin([
            'method' => 'get',
            'action' => \yii\helpers\Url::to(['analyze/product'])
        ]) ?>
        <div class="row">
            <div class="col-md-8">
                <?= \dosamigos\datepicker\DateRangePicker::widget([
                    'name' => 'dateFrom',
                    'value' => !empty($dateFrom) ? $dateFrom : date('Y-m-01'),
                    'nameTo' => 'dateTo',
                    'valueTo' => !empty($dateTo) ? $dateTo : date('Y-m-d'),
                    'labelTo' => 'До',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]); ?>

            </div>

            <div class="col-md-4">
                <?= \yii\helpers\Html::button('<i class="glyphicon glyphicon-ok"></i> Сформулировать отчет', [
                    'class' => 'btn btn-success pull-right',
                    'type' => 'submit'
                ]) ?>
            </div>
        </div>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>

<?= \yii\helpers\Html::a('< Назад', ['product/'], ['class' => 'btn btn-info']) ?>

    <hr>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'value' => 'product.title',
            'attribute' => 'product_title'
        ],
        'created_at',
        'increase',
        'decrease',
    ]
]); ?>