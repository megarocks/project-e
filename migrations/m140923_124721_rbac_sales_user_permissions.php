<?php

    use app\models\User;
    use app\rbac\AccessToSalesUserRule;
    use yii\db\Schema;
    use yii\db\Migration;

    class m140923_124721_rbac_sales_user_permissions extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;
            $endyMed = $auth->getRole(User::ROLE_ENDY);

            $viewSalesUser = $auth->createPermission('viewSalesUser');
            $viewSalesUser->description = 'View Sales User';

            $listSalesUsers = $auth->createPermission('listSalesUsers');
            $listSalesUsers->description = 'List Sales Users';

            $createSalesUsers = $auth->createPermission('createSalesUser');
            $createSalesUsers->description = 'Create Sales User';

            $updateSalesUser = $auth->createPermission('updateSalesUser');
            $updateSalesUser->description = 'Update Sales User';

            $deleteSalesUser = $auth->createPermission('deleteSalesUser');
            $deleteSalesUser->description = 'Delete Sales User';

            $salesUserAccessRule = new AccessToSalesUserRule();
            $auth->add($salesUserAccessRule);

            $viewSalesUser->ruleName = $salesUserAccessRule->name;
            $updateSalesUser->ruleName = $salesUserAccessRule->name;
            $deleteSalesUser->ruleName = $salesUserAccessRule->name;

            $auth->add($viewSalesUser);
            $auth->add($listSalesUsers);
            $auth->add($createSalesUsers);
            $auth->add($updateSalesUser);
            $auth->add($deleteSalesUser);

            $auth->addChild($endyMed, $viewSalesUser);
            $auth->addChild($endyMed, $listSalesUsers);
            $auth->addChild($endyMed, $createSalesUsers);
            $auth->addChild($endyMed, $updateSalesUser);
            $auth->addChild($endyMed, $deleteSalesUser);

            $auth->update($endyMed->name, $endyMed);

        }

        public function down()
        {
            echo "m140923_124721_rbac_sales_user_permissions cannot be reverted.\n";

            return false;
        }
    }
