<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140908_153406_rbac_eu_view_payment_details extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            $eu = $auth->getRole(\app\models\User::ROLE_END_USER);

            $viewPayment = $auth->getPermission('viewPayment');

            $auth->addChild($eu, $viewPayment);
        }

        public function down()
        {
            echo "m140908_153406_rbac_eu_view_payment_details cannot be reverted.\n";

            return false;
        }
    }
