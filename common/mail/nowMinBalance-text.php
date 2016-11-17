<?php
use yii\helpers\Html;
/* @var ending */
/* @var endingCount */
/* @var ended */
/* @var endedCount */
?>
Добрый день.
<?php if($endingCount > 0):?>
У Вас на складе заканчивается товар:
<?php $str1 = $title." ".$nomenclature." ".$article." ".$barcode." ".$code_client." осталось = ";?>
<?= Html::encode($str1)?> <?=$balance;?>    
<?php endif;?>
<?php if($endedCount > 0):?>
У Вас на складе заканчился товар:
<?php $str2 = $title." ".$nomenclature." ".$article." ".$barcode." ".$code_client;?>
<?= Html::encode($str2)?>    
<?php endif;?>