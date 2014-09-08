<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140908_152842_rbac_distr_view_payment_details extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            $distributor = $auth->getRole(\app\models\User::ROLE_DISTR);

            $viewPayment = $auth->getPermission('viewPayment');

            $auth->addChild($distributor, $viewPayment);

        }

        public function down()
        {
            echo "m140908_152842_rbac_distr_view_payment_details cannot be reverted.\n";

            return false;
        }
    }
