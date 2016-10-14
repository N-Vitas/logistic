<?php $user = \Yii::$app->user->getIdentity(); ?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if ($user->image) : ?>
                    <img src="<?= \yii\helpers\Url::to('@web/' . $user->image)?>" class="img-circle" alt="User Image"/>
                <?php endif; ?>

                <?php if (!$user->image) : ?>
                    <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                <?php endif; ?>
            </div>
            <div class="pull-left info">
                <p><?= $user->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--                <input type="text" name="q" class="form-control" placeholder="Search..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>-->
        <!-- /.search form -->


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Остатки на складе', 'icon' => 'fa fa-archive', 'url' => ['/product']],
                    ['label' => 'Заказы на доставку', 'icon' => 'fa fa-truck', 'url' => ['/order']],
                    [
                        'label' => 'Аналитика и отчеты',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Менеджеры', 'icon' => 'fa fa-users', 'url' => ['analyze/user'],
                                'visible' => \Yii::$app->user->can('createClientManager'),
                            ],
                            ['label' => 'Остатки на складе', 'icon' => 'fa fa-archive', 'url' => ['analyze/product'],],
                            ['label' => 'Доставка', 'icon' => 'fa fa-truck', 'url' => ['analyze/order'],],
                            ['label' => 'Наложенные платежи', 'icon' => 'fa fa-dollar', 'url' => ['analyze/payments'],],

                        ],
//                        'visible' =>
                    ],


                    [
                        'label' => 'Настройки',
                        'icon' => 'fa fa-gear',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Мой профиль',
                                'icon' => 'fa fa-user',
                                'url' => ['site/profile'],
                            ],
                            [
                                'label' => 'Настройка сервиса',
                                'icon' => 'fa fa-gear',
                                'url' => ['/notifications'],
                            ],
                            [
                                'label' => 'Мои менеджеры',
                                'icon' => 'fa fa-users',
                                'url' => ['/user'],
                                'visible' => \Yii::$app->user->can('createClientManager')
                            ],

                        ]
                    ],

                ],
            ]
        ) ?>

    </section>

</aside>
