<?php

    namespace app\helpers;

    use Yii;
    use yii\bootstrap\Nav;
    use kartik\widgets\SideNav;
    use yii\widgets\Menu;

    class RoleNavHelper
    {
        /**
         * Renders navigation menu with permitted menu items
         *
         * @return string
         */
        public static function navigationMenu()
        {
            return Menu::widget([
                'options' => [
                    'class' => 'nav nav-list',
                    'style' => 'top: 0px;',
                    'activateParents' => true,
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
                ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index'], 'permission' => 'viewDashboard', 'active' => Yii::$app->controller->id == 'site' ? true : false],
                ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['/purchase-order/index'], 'permission' => 'listPurchaseOrders', 'active' => Yii::$app->controller->id == 'purchase-order' ? true : false],
                ['label' => Yii::t('app', 'Payments'), 'url' => ['/payment/index'], 'permission' => 'listPayments', 'active' => Yii::$app->controller->id == 'payment' ? true : false],
                ['label' => Yii::t('app', 'Systems'), 'url' => ['/system/index'], 'permission' => 'listSystems', 'active' => Yii::$app->controller->id == 'system' ? true : false, 'visible' => !Yii::$app->session->get('loggedByCode')],
                ['label' => Yii::t('app', 'View System'), 'url' => ['/system/view-system'], 'permission' => 'viewSingleSystem', 'active' => Yii::$app->controller->id == 'system' ? true : false, 'visible' => Yii::$app->session->get('loggedByCode')],
                ['label' => Yii::t('app', 'Distributors'), 'url' => ['/distributor/index'], 'permission' => 'listDistributors', 'active' => Yii::$app->controller->id == 'distributor' ? true : false],
                ['label' => Yii::t('app', 'End-Users'), 'url' => ['/end-user/index'], 'permission' => 'listEndUsers', 'active' => Yii::$app->controller->id == 'end-user' ? true : false],
                ['label' => Yii::t('app', 'Sales-Users'), 'url' => ['/sales-user/index'], 'permission' => 'listSalesUsers', 'active' => Yii::$app->controller->id == 'sales-user' ? true : false],
                ['label' => Yii::t('app', 'Manufacturers'), 'url' => ['/manufacturer/index'], 'permission' => 'listManufacturers', 'active' => Yii::$app->controller->id == 'manufacturer' ? true : false],
                ['label' => Yii::t('app', 'Admins'), 'url' => ['/user'], 'permission' => 'listUsers', 'active' => Yii::$app->controller->id == 'user' ? true : false],
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