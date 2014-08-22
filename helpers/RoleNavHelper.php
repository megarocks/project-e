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
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    ['label' => Yii::t('app', 'Systems'), 'url' => ['/system/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] :
                        ['label'       => Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->first_name . ')',
                         'url'         => ['/site/logout'],
                         'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
        }

        private static function renderEndUserNav()
        {
            return Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => [
                    ['label' => Yii::t('app', 'System'), 'url' => ['/system/view-by-code']],
                    Yii::$app->user->isGuest ?
                        ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] :
                        ['label'       => Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->first_name . ')',
                         'url'         => ['/site/logout'],
                         'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
        }

        private static function renderEndyMedNav()
        {
            return Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['/purchase-order/index']],
                    ['label' => Yii::t('app', 'Systems'), 'url' => ['/system/index']],
                    ['label' => Yii::t('app', 'Distributors'), 'url' => ['/distributor/index']],
                    ['label' => Yii::t('app', 'End-Users'), 'url' => ['/end-user/index']],
                    ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] :
                        ['label'       => Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->first_name . ')',
                         'url'         => ['/site/logout'],
                         'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
        }

        private static function renderManufacturerNav()
        {
            return Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['/purchase-order/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] :
                        ['label'       => Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->first_name . ')',
                         'url'         => ['/site/logout'],
                         'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
        }

        private static function renderSalesNav()
        {
            return Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['/purchase-order/index']],
                    ['label' => Yii::t('app', 'Distributors'), 'url' => ['/distributor/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] :
                        ['label'       => Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->first_name . ')',
                         'url'         => ['/site/logout'],
                         'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
        }

        private static function renderDefaultNav()
        {
            return Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => [
                    ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] :
                        ['label'       => Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->first_name . ')',
                         'url'         => ['/site/logout'],
                         'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
        }
    }