<?php
use yii\grid\GridView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $dateFrom string
 * @var $dateTo string
 */

$this->title = "Отчет по менеджерам";
?>
<?= $this->render('_client_form'); ?>

    <div class="pull-right">
        <?php \yii\widgets\ActiveForm::begin([
            'method' => 'get',
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
<?= \yii\helpers\Html::a('< Назад', ['user/'], ['class' => 'btn btn-info']) ?>

    <hr>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'username',
        [
            'attribute' => 'newOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getNewOrdersCount($dateFrom, $dateTo);
            }
        ],
        [
            'attribute' => 'workOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getWorkOrdersCount($dateFrom, $dateTo);
            }
        ],
        [
            'attribute' => 'completeOrderCount',
            'value' => function($model) use ($dateFrom, $dateTo) {
                return $model->getCompleteOrdersCount($dateFrom, $dateTo);
            }
        ],
        // 'created_at',
    ],
]); ?>