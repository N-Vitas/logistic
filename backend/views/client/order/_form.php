<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */

$client = \common\models\Client::findOne(['is_id' => $model->client_id]);

$products = \common\models\Product::find()
    ->where(['client_id' => $client->is_id])
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

$this->registerJs("
productLabels = $jsonLabels;
productPrices = $jsonPrices;
productBalance = $jsonBalance;
productIds = {};

$('.add-product').click(function() {
    productId = $($(this).data('select')).val();
    if (productId && !productIds[productId]) {
        $('.no-products').addClass('hidden');
        productIds[productId] = {price : 0, quantity : 1};
        $('.products-list').append('<tr class=\"product-'+productId+'\"><td>'
        +productLabels[productId]+
        '</td><td>'+
        '<input class=\"form-control product-price-'+productId+'\" data-id=\"'+productId+'\" placeholder=\"Цена\" required value=\"0\">'
        +'</td><td>'
        + '<div class=\"input-group\">'
        +'<input class=\"form-control product-quantity-'+productId+'\" data-id=\"'+productId+'\" placeholder=\"Кол-во\" required value=\"1\" type=\"number\">'
         +'<span class=\"input-group-addon\" id=\"basic-addon2\"> / '+ productBalance[productId] + '</span>' 
         + '</div>'
         +'</td><td>'+
        '<a class=\"btn btn-danger cancel-item-'+productId+'\" data-id=\"'+productId+'\"><i class=\"glyphicon glyphicon-trash\"></i></a>'
        +'</td><td id=\'product-total-'+productId+'\'></td>></tr>');
        
        reloadInfo();

        $('.cancel-item-'+productId+'').click(function() {
            $('.product-' + $(this).data('id')).remove();
            delete productIds[$(this).data('id')];
            
            reloadInfo();
        });
        
        $('.product-price-'+productId+'').change(function() {
            productIds[$(this).data('id')].price = $(this).val();
            
            reloadInfo();
        });
        $('.product-quantity-'+productId+'').change(function() {
            curval = $(this).val();
            balance = productBalance[$(this).data('id')];
            
            
            if (parseInt(curval) > parseInt(balance)) {
                quantity = balance;
                $(this).val(quantity);
            } else {
                quantity = curval;
            }
            productIds[$(this).data('id')].quantity = quantity;
            
            reloadInfo();
        });
    }
});

reloadInfo = function() {
    $('.products-info').val(JSON.stringify(productIds));
    sum = 0;
    for (i in productIds) {
        sum += parseInt(productIds[i].price) * parseInt(productIds[i].quantity);
        $('#product-total-' + i).html('Итого: ' + (parseInt(productIds[i].price) * parseInt(productIds[i].quantity)));
    }
    
    $('#total-price').val(sum);
}

$('#order-no_shipping').change(function() {
    if($(this).is(\":checked\")) {
        $('.no-shipping-hide').hide();
    } else {    
        $('.no-shipping-hide').show();
    }        
});
");
?>

<div class="order-form">

    <?php if ($model->getErrors()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($model->getErrors() as $error): ?>
                    <li><?php print_r($error[0]) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <h4>Товары для доставки</h4>
            <hr>

            <?php if ($model->isNewRecord): ?>
                <div>

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
                            <a href="#code-client" aria-controls="code-client" role="tab" data-toggle="tab">По коду
                                клиента</a>
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


                <h3>В заказе</h3>

                <div class="alert alert-warning no-products">
                    <i class="glyphicon glyphicon-chevron-up"></i> Выберите товары
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Наименование</th>
                        <th style="width: 35%">Цена</th>
                        <th style="width: 35%">Кол-во</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="products-list">
                    </tbody>
                </table>
                <?= Html::input('hidden', 'products', null, [
                    'class' => 'products-info'
                ]) ?>
            <?php endif; ?>

            <?= $form->field($model, 'price')->textInput([
                'id' => 'total-price',
//                'disabled' => 'disabled'
            ]) ?>


            <?php if (!$model->isNewRecord): ?>
                <?= $form->field($model, 'status')->dropDownList($model::$statuses) ?>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h4>Информация о доставке</h4>
            <?= $form->field($model, 'no_shipping')->checkbox() ?>
            <?= $form->field($model, 'payment_type')->dropDownList($model::$paymentTypes) ?>

            <?php /*
 <?= $form->field($model, 'delivery_date')->widget(
                DateTimePicker::className(), [
                    'language' => 'en',
                    'size' => 'ms',
                    'pickButtonIcon' => 'glyphicon glyphicon-time',
                    'clientOptions' => [
                        'autoclose' => true,
//                        'linkFormat' => 'HH:ii P', // if inline = true
                        'format' => 'yyyy-mm-ddThh:ii', // if inline = false
                        'todayBtn' => true
                    ]
                ]
            ) ?>
 */ ?>

            <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>


            <div class="no-shipping-hide">
                <?= $form->field($model, 'city_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                    \common\models\City::find()->asArray()->all(), 'id', 'title'
                )) ?>
                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            </div>
            <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+7-999-999-9999',
            ]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'comment')->textarea() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
