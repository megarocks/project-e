<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140908_143936_rbac_man_orders extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            $endUser = $auth->getRole(\app\models\User::ROLE_MAN);

            $listPurchaseOrders = $auth->getPermission('listPurchaseOrders');
            $viewPurchaseOrder = $auth->getPermission('viewPurchaseOrder');


            $auth->addChild($endUser, $listPurchaseOrders);
            $auth->addChild($endUser, $viewPurchaseOrder);
        }

        public function down()
        {
            echo "m140908_143936_rbac_man_orders cannot be reverted.\n";

            return false;
        }
    }
