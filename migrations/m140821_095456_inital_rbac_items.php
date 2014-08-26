<?php

    use app\models\User;
    use yii\db\Schema;
    use yii\db\Migration;

    class m140821_095456_inital_rbac_items extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            $sales = $auth->createRole(User::ROLE_SALES);
            $manufacturer = $auth->createRole(User::ROLE_MAN);
            $endyMed = $auth->createRole(User::ROLE_ENDY);
            $distributor = $auth->createRole(User::ROLE_DISTR);
            $endUser = $auth->createRole(User::ROLE_END_USER);

            $auth->add($sales);
            $auth->add($manufacturer);
            $auth->add($endyMed);
            $auth->add($distributor);
            $auth->add($endUser);

            $auth->assign($endyMed, 1);
        }

        public function down()
        {
            echo "m140821_095456_inital_rbac_items cannot be reverted.\n";

            return false;
        }
    }
