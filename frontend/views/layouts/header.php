<?php
use yii\helpers\Html;
use \common\models\Product;

/* @var $this \yii\web\View */
/* @var $content string */

/* @var $user \common\models\User */
$user = Yii::$app->user->getIdentity();

$notificationsCount = 0;

$client = \Yii::$app->controller->client;

$lowProducts = \Yii::$app->controller->settings->low_products;
$countLowProducts = 0;
$countEnded = 0;
$products = Product::find()->where(['client_id' => $client->is_id])->all();
foreach ($products as $product) {
    $balance = $product->getBalance()->one();
    if($balance){
        if($product->balance < $balance->min_balance){
            $this->endingProducts[] = $product;
            $countLowProducts++;
        }
        if($product->balance == 0){
            $this->endedProducts[] = $product;
            $countEnded++;
        }
    }
}

// $countLowProducts = \common\models\Product::find()
//     ->where(['<', 'balance', $lowProducts])
//     ->count();

if ($countLowProducts) {
    $notificationsCount++;
}

// $countEnded = \common\models\Product::find()
//     ->where(['balance' => 0])
//     ->count();
if ($countEnded) {
    $notificationsCount++;
}

// $today = strtotime(date('Y-m-d'));
// $tomorrow = strtotime(date('Y-m-d') . ' +1 day');

$tomorrow = date('Y-m-d H:i:s',mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+1, date("Y")));// strtotime(date('Y-m-d') . ' -1 day');
$today = date('Y-m-d H:i:s',mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y")));//strtotime(date('Y-m-d') . '');

$countDelivered = \common\models\OrderLog::find()
    ->where(['status' => \common\models\Order::STATUS_COMPLETE])
    ->andWhere("created_at BETWEEN '$today' AND '$tomorrow'")
    ->count();
if ($countDelivered) {
    $notificationsCount++;
}

$countDelivering = \common\models\OrderLog::find()
    ->where(['status' => \common\models\Order::STATUS_DELIVERING])
    ->andWhere("created_at BETWEEN '$today' AND '$tomorrow'")
    ->count();
if ($countDelivering) {
    $notificationsCount++;
}


?>

<header class="main-header">

    <?= Html::a(
        '<span class="logo-mini">LGC</span><span class="logo-lg"><img src="'
        . \yii\helpers\Url::to('@web/images/logo.png') . '" height="40"></span>',
        Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <?php if($notificationsCount):?>
                            <span class="label label-warning"><?= $notificationsCount ?></span>
                        <?php endif;?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">У вас <?= $notificationsCount ?> уведомлений</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php if ($countEnded) : ?>
                                <li>
                                    <a href="<?= \yii\helpers\Url::to(['product/']) ?>">
                                        <i class="fa fa-warning text-yellow"></i> <?= $countEnded ?>
                                        единиц товара закончилось
                                    </a>
                                </li>
                                <?php endif ?>
                                <?php if ($countLowProducts) : ?>
                                <li>
                                    <a href="<?= \yii\helpers\Url::to(['product/']) ?>">
                                        <i class="fa fa-users text-aqua"></i> <?= $countLowProducts ?>
                                        единиц товара заканчивается
                                    </a>
                                </li>
                                <?php endif ?>

                                <?php if ($countDelivered) : ?>
                                    <li>
                                        <a href="<?= \yii\helpers\Url::to(['order/']) ?>">
                                            <i class="fa fa-users text-red"></i> <?= $countDelivered ?>
                                            заказов доставлено сегодня
                                        </a>
                                    </li>
                                <?php endif ?>
        
                                <?php if ($countDelivering) : ?>
                                    <li>
                                        <a href="<?= \yii\helpers\Url::to(['order/']) ?>">
                                            <i class="fa fa-shopping-cart text-green"></i> <?= $countDelivering ?>
                                            заказов отправлено сегодня
                                        </a>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </li>
<!--                        <li class="footer"><a href="#">View all</a></li>-->
                    </ul>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if ($user->image) : ?>
                            <img src="<?= \yii\helpers\Url::to('@web' . $user->image)?>" class="user-image" alt="User Image"/>
                        <?php else: ?>
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <?php endif; ?>
                        <span class="hidden-xs"><?= $user->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">

                            <?php if ($user->image) : ?>
                                <img src="<?= \yii\helpers\Url::to('@web' . $user->image)?>" class="img-circle" alt="User Image"/>
                            <?php else: ?>
                                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                            <?php endif; ?>

                            <p>
                                <?= $user->client->name ?> - <?= $user->username ?>
                                <small>Зарегестрирован с <?= date('M Y', $user->created_at) ?></small>
                            </p>
                        </li>
                        <?php /*
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        */ ?>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= \yii\helpers\Url::to(['site/profile']) ?>" class="btn btn-default btn-flat">Профиль</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выйти',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <a href="#" class="sidebar-toggle" data-toggle="control-sidebar" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </ul>
        </div>
    </nav>
</header>
