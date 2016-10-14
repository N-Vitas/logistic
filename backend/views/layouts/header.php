<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

/* @var $user \common\models\User */
$user = Yii::$app->user->getIdentity();
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

                <?php /*
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may
                                        not fit into the page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
 */ ?>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if ($user->image) : ?>
                            <img src="<?= \yii\helpers\Url::to('@web/' . $user->image)?>" class="user-image" alt="User Image"/>
                        <?php endif; ?>
                        
                        <?php if (!$user->image) : ?>
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <?php endif; ?>
                        <span class="hidden-xs"><?= $user->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php if ($user->image) : ?>
                                <img src="<?= \yii\helpers\Url::to('@web/' . $user->image)?>" class="img-circle" alt="User Image"/>
                            <?php endif; ?>

                            <?php if (!$user->image) : ?>
                                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                            <?php endif; ?>

                            <p>
                                <?= $user->username ?> - <?php print_r($user->userRoles) ?>
                                <small>Зарегестрирован с <?= date('M Y', $user->created_at) ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
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

            </ul>
        </div>
    </nav>
</header>
