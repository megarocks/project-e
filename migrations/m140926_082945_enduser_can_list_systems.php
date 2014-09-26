<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140926_082945_enduser_can_list_systems extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            $eu = $auth->getRole(\app\models\User::ROLE_END_USER);

            $listSystems = $auth->getPermission('listSystems');

            $auth->addChild($eu, $listSystems);

        }

        public function down()
        {
            echo "m140926_082945_enduser_can_list_systems cannot be reverted.\n";

            return false;
        }
    }
