<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m140821_095456_inital_rbac_items extends Migration
    {

        const ROLE_SALES = 'sales';
        const ROLE_PROD = 'production';
        const ROLE_ENDY = 'endymed';
        const ROLE_DISTR = 'distributor';
        const ROLE_END_USER = 'enduser';

        public function up()
        {
            $auth = \Yii::$app->authManager;

            $sales = $auth->createRole(static::ROLE_SALES);
            $production = $auth->createRole(static::ROLE_PROD);
            $endyMed = $auth->createRole(static::ROLE_ENDY);
            $distributor = $auth->createRole(static::ROLE_DISTR);
            $endUser = $auth->createRole(static::ROLE_END_USER);

            $auth->add($sales);
            $auth->add($production);
            $auth->add($endyMed);
            $auth->add($distributor);
            $auth->add($endUser);

            $auth->assign($sales, 1);
            $auth->assign($production, 2);
            $auth->assign($endyMed, 3);
            $auth->assign($distributor, 4);
            $auth->assign($endUser, 5);
            $auth->assign($endUser, 6);
        }

        public function down()
        {
            echo "m140821_095456_inital_rbac_items cannot be reverted.\n";

            return false;
        }
    }
