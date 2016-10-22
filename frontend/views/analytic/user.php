<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $dateFrom string
 * @var $dateTo string
 */

$this->title = "Отчет по менеджерам";
?>
    <div class="pull-right">
        <?php ActiveForm::begin([
            'method' => 'get',
            // 'action' => Url::to(['analyze/user'])
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
                <?= Html::button('<i class="glyphicon glyphicon-ok"></i> Сформулировать отчет', [
                    'class' => 'btn btn-success pull-right',
                    'type' => 'submit'
                ]) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
        <?= Html::a('< Назад', ['user/'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Экспорт в XLS', [Url::current(['xls' => true])], ['class' => 'btn btn-info']) ?>
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