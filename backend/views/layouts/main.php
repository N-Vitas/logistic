<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    app\assets\AppAsset::register($this);
}

dmstr\web\AdminLteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= \Yii::$app->name . ' - ' . Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-red-light sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
<?php 
    if(\Yii::$app->user->identity){
        echo $this->render('header.php',['directoryAsset' => $directoryAsset]);
        echo $this->render('left.php',['directoryAsset' => $directoryAsset]);
        echo $this->render('content.php',['content' => $content, 'directoryAsset' => $directoryAsset]);
    }
    else{
        echo $this->render('main-login.php',['content' => $content,'directoryAsset' => $directoryAsset]);
    }
?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
