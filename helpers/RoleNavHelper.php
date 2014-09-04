<?php

    namespace app\helpers;

    use app\models\User;
    use Yii;
    use yii\bootstrap\Nav;

    class RoleNavHelper
    {
        /**
         * Renders Nav widget with items accordingly to specified role
         * @param null $role
         * @return mixed
         */
        public static function renderNav($role = null)
        {
            switch ($role) {
                case User::ROLE_DISTR:
                    return static::renderDistributorNav();
                    break;
                case User::ROLE_END_USER:
                    return static::renderEndUserNav();
                    break;
                case User::ROLE_ENDY:
                    return static::renderEndyMedNav();
                    break;
                case User::ROLE_MAN:
                    return static::renderManufacturerNav();
                    break;
                case User::ROLE_SALES:
                    return static::renderSalesNav();
                    break;
                default:
                    return static::renderDefaultNav();
            }
        }

        private static function renderDistributorNav()
        {
            return Nav::widget([
                'options' => [
                    'class' => 'nav nav-list',
                    'style' => 'top: 0px;',
                ],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    ['label' => Yii::t('app', 'Systems'), 'url' => ['/system/index']],
                    ['label' => Yii::t('app', 'End-Users'), 'url' => ['/end-user/index']],
                ],
            ]);
        }

        private static function renderEndUserNav()
        {
            return Nav::widget([
                'options' => [
                    'class' => 'nav nav-list',
                    'style' => 'top: 0px;',
                ],
                'items'   => [
                    ['label' => Yii::t('app', 'System'), 'url' => ['/system/view-by-code']],
                ],
            ]);
        }

        private static function renderEndyMedNav()
        {
            return Nav::widget([
                'options' => [
                    'class' => 'nav nav-list',
                    'style' => 'top: 0px;',
                ],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['/purchase-order/index']],
                    ['label' => Yii::t('app', 'Payments'), 'url' => ['/payment/index']],
                    ['label' => Yii::t('app', 'Systems'), 'url' => ['/system/index']],
                    ['label' => Yii::t('app', 'Distributors'), 'url' => ['/distributor/index']],
                    ['label' => Yii::t('app', 'End-Users'), 'url' => ['/end-user/index']],
                    ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']],
                ],

            ]);
        }

        private static function renderManufacturerNav()
        {
            return Nav::widget([
                'options' => [
                    'class' => 'nav nav-list',
                    'style' => 'top: 0px;',
                ],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    ['label' => Yii::t('app', 'Systems'), 'url' => ['/system/index']],
                ],
            ]);
        }

        private static function renderSalesNav()
        {
            return Nav::widget([
                'options' => [
                    'class' => 'nav nav-list',
                    'style' => 'top: 0px;',
                ],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['/purchase-order/index']],
                    ['label' => Yii::t('app', 'Distributors'), 'url' => ['/distributor/index']],
                    ['label' => Yii::t('app', 'End-Users'), 'url' => ['/end-user/index']],
                ],
            ]);
        }

        private static function renderDefaultNav()
        {
            /*            return Nav::widget([
                            'options' => ['class' => 'navbar-nav navbar-right'],
                            'items'   => [
                                ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                            ],
                        ]);*/
        }


        public static function profileMenu($isGuest)
        {
            return Nav::widget([
                'options' => [
                    'class' => 'navbar-nav navbar-right',
                    'role'  => 'navigation',
                ],
                'items'   => [
                    static::getProfileMenuItems($isGuest)
                ]
            ]);
        }

        /**
         * Method returns array with menu items for profile area: login, logout, view/edit profile
         *
         * @param $isGuest
         * @return array
         */
        private static function getProfileMenuItems($isGuest)
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
    }