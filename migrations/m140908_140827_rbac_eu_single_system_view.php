<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140908_140827_rbac_eu_single_system_view extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            $endUser = $auth->getRole(\app\models\User::ROLE_END_USER);

            $viewEuSingleSystem = $auth->createPermission('viewSingleSystem');
            $viewEuSingleSystem->description = 'Capability to view details of single EU system';

            $auth->add($viewEuSingleSystem);

            $auth->addChild($endUser, $viewEuSingleSystem);
        }

        public function down()
        {
            echo "m140908_140827_rbac_eu_single_system_view cannot be reverted.\n";

            return false;
        }
    }
