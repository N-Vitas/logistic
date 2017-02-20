<?php
/* @var $user \common\models\User */
$user = \Yii::$app->user->identity; ?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">

                <?php if ($user->image) : ?>
                    <img src="<?= \yii\helpers\Url::to('@web' . $user->image)?>" class="img-circle" alt="User Image"/>
                <?php else: ?>
                    <img src="/images/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                <?php endif; ?>
            </div>
            <div class="pull-left info">
                <p><?= $user->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
<?php /*

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
 */ ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Управление сервисом', 'options' => ['class' => 'header']],
                    ['label' => 'Клиенты', 'icon' => 'fa fa-briefcase', 'url' => ['/client']],
                    ['label' => 'Менеджеры сервиса', 'icon' => 'fa fa-users', 'url' => ['/user']],

                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    // [
                    //     'label' => 'Настройки',
                    //     'icon' => 'fa fa-gear',
                    //     'url' => '#',
                    //     'items' => [
                    //         // ['label' => 'Настройки сервиса', 'icon' => 'fa fa-gear', 'url' => ['/settings']],
                    //         ['label' => 'Профиль', 'icon' => 'fa fa-user', 'url' => ['site/profile']],
                    //         ['label' => 'Города', 'icon' => 'fa fa-building', 'url' => ['/city']],

                    //     ],
                    // ],
                    [
                        'label' => 'Аналитика и отчеты',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Менеджеры', 'icon' => 'fa fa-users', 'url' => ['/analytic/user'],
                                'visible' => \Yii::$app->user->can('createClientManager'),
                            ],
                            ['label' => 'Остатки на складе', 'icon' => 'fa fa-archive', 'url' => ['/analytic/product']],
                            ['label' => 'Движение товара', 'icon' => 'glyphicon glyphicon-transfer', 'url' => ['analytic/motion']],
                            ['label' => 'Доставка', 'icon' => 'fa fa-truck', 'url' => ['/analytic/delivery'],],
                            ['label' => 'Наложенные платежи', 'icon' => 'fa fa-dollar', 'url' => ['/analytic/payments']],

                        ],
//                        'visible' =>
                    ],
                    // [
                    //     'label' => 'Панель разработчика',
                    //     'icon' => 'fa fa-share',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                    //         ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                    //     ],

                    //     'visible' => YII_DEBUG
                    // ],
                ],
            ]
        ) ?>

    </section>

</aside>
