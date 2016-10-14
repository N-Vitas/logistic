<?php
use yii\grid\GridView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */


$products = \common\models\Product::find()
    ->where(['client_id' => Yii::$app->controller->client_id])
    ->asArray()
    ->all();

$productLabels = \yii\helpers\ArrayHelper::map($products, 'id', 'title');
$productArticles = \yii\helpers\ArrayHelper::map($products, 'id', 'article');
$productNomenclature = \yii\helpers\ArrayHelper::map($products, 'id', 'nomenclature');
$productCodeClient = \yii\helpers\ArrayHelper::map($products, 'id', 'code_client');
$jsonLabels = json_encode($productLabels);
$productPrices = \yii\helpers\ArrayHelper::map($products, 'id', 'price');
$jsonPrices = json_encode($productPrices);

$productBalance = \yii\helpers\ArrayHelper::map($products, 'id', 'balance');
$jsonBalance = json_encode($productBalance);

$products = !empty($_GET['products']) ? $products = $_GET['products'] : "{}";

$this->registerJs("
productLabels = $jsonLabels;
productPrices = $jsonPrices;
productBalance = $jsonBalance;
productIds = $products;

$('.add-product').click(function() {
    productId = $($(this).data('select')).val();
    if (productId && !productIds[productId]) {
        $('.no-products').addClass('hidden');
        productIds[productId] = productId;
        $('.products-list').append('<tr class=\"product-'+productId+'\"><td>'
        +productLabels[productId]+
        '</td><td>'+
        '<a class=\"btn btn-danger cancel-item-'+productId+'\" data-id=\"'+productId+'\"><i class=\"glyphicon glyphicon-trash\"></i></a>'
        +'</td><td id=\'product-total-'+productId+'\'></td>></tr>');
        
        reloadInfo();

        $('.cancel-item-'+productId+'').click(function() {
            $('.product-' + $(this).data('id')).remove();
            delete productIds[$(this).data('id')];
            
            reloadInfo();
        });
        
    }
});

reloadInfo = function() {
    $('.products-info').val(JSON.stringify(productIds));
}
reloadInfo();
function init() {
    for (productId in productIds) {
        $('.no-products').addClass('hidden');
        productIds[productId] = productId;
        $('.products-list').append('<tr class=\"product-'+productId+'\"><td>'
        +productLabels[productId]+
        '</td><td>'+
        '<a class=\"btn btn-danger cancel-item-'+productId+'\" data-id=\"'+productId+'\"><i class=\"glyphicon glyphicon-trash\"></i></a>'
        +'</td><td id=\'product-total-'+productId+'\'></td>></tr>');
        
        reloadInfo();

        $('.cancel-item-'+productId+'').click(function() {
            $('.product-' + $(this).data('id')).remove();
            delete productIds[$(this).data('id')];
            
            reloadInfo();
        });
    }
}
init();

");

$this->title = "Отчет по платежам";
?>


<?= $this->render('_client_form'); ?>

<?php \yii\widgets\ActiveForm::begin([
    'method' => 'get',
    'action' => \yii\helpers\Url::to(['analyze/payments'])
]) ?>

    <div class="pull-right">
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

    </div>
    <h1>Фильтр</h1>

    <div class="row">
        <div class="col-md-6">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#product" aria-controls="product" role="tab" data-toggle="tab">По наименованию</a>
                </li>
                <li role="presentation">
                    <a href="#article" aria-controls="article" role="tab" data-toggle="tab">По артиклю</a>
                </li>
                <li role="presentation">
                    <a href="#nomenclature" aria-controls="nomenclature" role="tab" data-toggle="tab">По
                        номенклатуре</a>
                </li>

                <li role="presentation">
                    <a href="#code-client" aria-controls="code-client" role="tab" data-toggle="tab">По коду клиента</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="product">
                    <h4>По наименованию:</h4>

                    <div class="row">
                        <div class="col-md-9">
                            <?= \kartik\select2\Select2::widget([
                                'name' => '',
                                'value' => '',
                                'data' => $productLabels,
                                'options' => [
                                    'placeholder' => 'Выберите товар...',
                                    'id' => 'product-select'
                                ]
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-success add-product btn-block"
                               data-select="#product-select">
                                <i class="glyphicon glyphicon-plus"></i> Добавить
                            </a>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="article">
                    <h4>По артиклю:</h4>
                    <div class="row">
                        <div class="col-md-9">

                            <?= \kartik\select2\Select2::widget([
                                'name' => '',
                                'value' => '',
                                'data' => $productArticles,
                                'options' => [
                                    'placeholder' => 'Выберите артикуль...',
                                    'id' => 'article-select'
                                ]
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-success add-product btn-block"
                               data-select="#article-select">
                                <i class="glyphicon glyphicon-plus"></i> Добавить
                            </a>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="nomenclature">
                    <h4>По номенклатуре:</h4>
                    <div class="row">
                        <div class="col-md-9">
                            <?= \kartik\select2\Select2::widget([
                                'name' => '',
                                'value' => '',
                                'data' => $productNomenclature,
                                'options' => [
                                    'placeholder' => 'Выберите номенклатуру...',
                                    'id' => 'nomenclature-select'
                                ]
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-success add-product btn-block"
                               data-select="#nomenclature-select">
                                <i class="glyphicon glyphicon-plus"></i> Добавить
                            </a>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="code-client">
                    <h4>По коду клиента:</h4>
                    <div class="row">
                        <div class="col-md-9">
                            <?= \kartik\select2\Select2::widget([
                                'name' => '',
                                'value' => '',
                                'data' => $productCodeClient,
                                'options' => [
                                    'placeholder' => 'Выберите код клиента...',
                                    'id' => 'code-client-select'
                                ]
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-success add-product btn-block"
                               data-select="#code-client-select">
                                <i class="glyphicon glyphicon-plus"></i> Добавить
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <h3>в фильтре</h3>

            <div class="alert alert-warning no-products">
                <i class="glyphicon glyphicon-chevron-left"></i> Выберите товары
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th>Наименование</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="products-list">
                </tbody>
            </table>
        </div>
    </div>



<?= \yii\helpers\Html::input('hidden', 'products', null, [
    'class' => 'products-info'
]) ?>

<?php \yii\widgets\ActiveForm::end() ?>

    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-success">
                <h3>Итого наложенных платежей получено согласно фильтра</h3>
                <h1><?= $finishedPayments ?></h1>
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-success">
                <h3>Итого наложенных платежей ожидается согласно</h3>
                <h1><?= $toFinishPayments ?></h1>
            </div>
        </div>
    </div>

    <hr>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'created_at',
        'city.title',
        'address',
        'client_name',
        'phone',
        // 'product_id',
        // 'email:email',
        'paymentType',
        'price',

        [
            'attribute' => 'orderStatus',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getOrderStatus();
            },
            'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'orderStatus', \common\models\Order::$statuses),

        ],

        'delivery_date',
        [
            'format' => 'raw',
            'value' => function($model) {
                $viewButton = \yii\helpers\Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                    ['view', 'id' => $model->id], [
                        'class' => 'btn btn-info'
                    ]);
                return $viewButton;
            }
        ]
    ],
]); ?>