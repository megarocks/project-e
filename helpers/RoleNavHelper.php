<?php

    namespace app\helpers;

    use app\models\User;
    use Yii;
    use yii\bootstrap\Nav;

    class RoleNavHelper
    {
        /**
         * Renders navigation menu with permitted menu items
         *
         * @return string
         */
        public static function navigationMenu()
        {
            return Nav::widget([
                'options' => [
                    'class' => 'nav nav-list',
                    'style' => 'top: 0px;',
                ],
                'items'   => static::permittedMenuItems()
            ]);
        }

        /**
         * Renders profile menu dropdown items
         *
         * @param $isGuest
         * @return string
         */
        public static function profileMenu($isGuest)
        {
            return Nav::widget([
                'options' => [
                    'class' => 'navbar-nav navbar-right',
                    'role'  => 'navigation',
                ],
                'items'   => [
                    static::ProfileMenuItems($isGuest)
                ]
            ]);
        }

        /**
         * Method returns array with menu items for profile area: login, logout, view/edit profile
         *
         * @param $isGuest
         * @return array
         */
        private static function profileMenuItems($isGuest)
        {
            if (!$isGuest) {
                $menuItems = [
                    'label' => Yii::t('app', 'Logged as: ') . Yii::$app->user->identity->first_name,
                    'items' => [
                        [
                            'label' => Yii::t('app', 'View/Edit Profile'),
                            'url'   => ['user/profile']
                        ],
                        [
                            'label'       => Yii::t('app', 'Logout'),
                            'url'         => ['site/logout'],
                            'linkOptions' => ['data-method' => 'post'],
                        ]
                    ]
                ];
            } else {
                $menuItems = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            }

            return $menuItems;
        }

        /**
         * @return array
         */
        private static function allMenuItems()
        {
            return [
                ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index'], 'permission' => 'viewDashboard'],
                ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['/purchase-order/index'], 'permission' => 'listPurchaseOrders'],
                ['label' => Yii::t('app', 'Payments'), 'url' => ['/payment/index'], 'permission' => 'listPayments'],
                ['label' => Yii::t('app', 'Systems'), 'url' => ['/system/index'], 'permission' => 'listSystems'],
                ['label' => Yii::t('app', 'Distributors'), 'url' => ['/distributor/index'], 'permission' => 'listDistributors'],
                ['label' => Yii::t('app', 'End-Users'), 'url' => ['/end-user/index'], 'permission' => 'listEndUsers'],
                ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index'], 'permission' => 'listUsers'],
            ];
        }

        /**
         * @return array
         */
        private static function permittedMenuItems()
        {
            $permittedMenuItems = [];
            foreach (static::allMenuItems() as $menuItem) {
                if (Yii::$app->user->can($menuItem['permission'])) {
                    array_push($permittedMenuItems, $menuItem);
                }
            }

            return $permittedMenuItems;
        }
    }