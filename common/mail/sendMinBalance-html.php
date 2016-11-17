<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var ending */
/* @var endingCount */
/* @var ended */
/* @var endedCount */

/*
Добрый день.
Напоминаем о заканчивающемся товаре:
Название товара 1, номенклатура, артикуль (если есть), штрихкод (если есть), код клиента (если есть) - количество товара
Название товара 2, номенклатура, артикуль (если есть), штрихкод (если есть), код клиента (если есть) - количество товара
Название товара 3, номенклатура, артикуль (если есть), штрихкод (если есть), код клиента (если есть) - количество товара
*/
?>
<div class="password-reset">
    <p>Добрый день.</p>

    <?php if($endingCount > 0):?>
    	<p><b>Напоминаем о заканчивающемся товаре:</b></p>
	    <?php foreach ($ending as $productEnding):?>
	    	<?php $str1 = $productEnding->title." ".$productEnding->nomenclature." ".$productEnding->article." ".$productEnding->barcode." ".$productEnding->code_client." осталось = ";?>
	    	<p><?= Html::encode($str1)?><b><?=$productEnding->balance;?></b></p>    	
	    <?php endforeach;?>
    <?php endif;?>
    <?php if($endedCount > 0):?>
    	<p><b>Напоминаем о заканчившемся товаре:</b></p>
	    <?php foreach ($ended as $productEnded):?>
	    	<?php $str2 = $productEnded->title." ".$productEnded->nomenclature." ".$productEnded->article." ".$productEnded->barcode." ".$productEnded->code_client;?>
	    	<p><?= Html::encode($str2)?> </p>   
	    <?php endforeach;?>
    <?php endif;?>
</div>