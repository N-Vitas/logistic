<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (class_exists('frontend\assets\AppAsset')) {
    frontend\assets\AppAsset::register($this);
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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
  <?php if(\Yii::$app->user->identity):?>
    <?= $this->render(
        'header.php',
        ['directoryAsset' => $directoryAsset]
    ) ?>

    <?= $this->render(
        'left.php',
        ['directoryAsset' => $directoryAsset]
    )
    ?>
    <?= $this->render(
        'content.php',
        ['content' => $content, 'directoryAsset' => $directoryAsset]
    ) ?>
  <? else:?>
    <?= $this->render(
        'main-login.php',
        ['content' => $content,'directoryAsset' => $directoryAsset]
    )
    ?>
  <? endif;?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
