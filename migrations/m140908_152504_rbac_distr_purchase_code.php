<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140908_152504_rbac_distr_purchase_code extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            $distributor = $auth->getRole(\app\models\User::ROLE_DISTR);

            $purchaseCode = $auth->getPermission('purchaseCode');

            $auth->addChild($distributor, $purchaseCode);
        }

        public function down()
        {
            echo "m140908_152504_rbac_distr_purchase_code cannot be reverted.\n";

            return false;
        }
    }
