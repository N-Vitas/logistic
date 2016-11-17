<?php
use yii\helpers\Html;
/* @var ending */
/* @var endingCount */
/* @var ended */
/* @var endedCount */
?>
Добрый день.

<?php if($endingCount > 0):?>
	Напоминаем о заканчивающемся товаре:
<?php foreach ($ending as $productEnding):?>
<?php $str1 = $productEnding->title." ".$productEnding->nomenclature." ".$productEnding->article." ".$productEnding->barcode." ".$productEnding->code_client." осталось = ".$productEnding->balance;?>
<?= Html::encode($str1)?>
<?php endforeach;?>
<?php endif;?>

<?php if($endedCount > 0):?>
	Напоминаем о заканчившемся товаре:
<?php foreach ($ended as $productEnded):?>
<?php $str2 = $productEnded->title." ".$productEnded->nomenclature." ".$productEnded->article." ".$productEnded->barcode." ".$productEnded->code_client;?>
<?= Html::encode($str2)?> 
<?php endforeach;?>
<?php endif;?>