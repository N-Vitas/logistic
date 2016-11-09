<?php

use yii\helpers\Html;

echo Html::beginForm('', 'post');
echo Html::dropDownList('list_view', $view, ['list'=>'Показывать в виде блоков','table'=>'Показывать в виде списка'],['class'=>'form-control','onChange'=>'this.form.submit()']);
echo Html::endForm();
?>
