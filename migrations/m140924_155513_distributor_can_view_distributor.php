<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140924_155513_distributor_can_view_distributor extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            $distributor = $auth->getRole(\app\models\User::ROLE_DISTR);

            $viewDistributor = $auth->getPermission('viewDistributor');

            $auth->addChild($distributor, $viewDistributor);
        }

        public function down()
        {
            echo "m140924_155513_distributor_can_view_distributor cannot be reverted.\n";

            return false;
        }
    }
