<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var ending */
/* @var endingCount */
/* @var ended */
/* @var endedCount */

/*
Добрый день.
У Вас на складе заканчивается товар:
Название товара, номенклатура, артикуль (если есть), штрихкод (если есть), код клиента (если есть) - количество товара
*/
?>
<div class="password-reset">
    <p>Добрый день.</p>

    <?php if($endingCount > 0):?>
    	<p><b>У Вас на складе заканчивается товар:</b></p>
	    	<?php $str1 = $title." ".$nomenclature." ".$article." ".$barcode." ".$code_client." осталось = ";?>
	    	<p><?= Html::encode($str1)?><b><?=$balance;?></b></p>    
    <?php endif;?>
    <?php if($endedCount > 0):?>
    	<p><b>У Вас на складе заканчился товар:</b></p>
	    	<?php $str2 = $title." ".$nomenclature." ".$article." ".$barcode." ".$code_client;?>
	    	<p><?= Html::encode($str2)?> </p>   
    <?php endif;?>
</div>