<?php

    use app\models\User;
    use yii\db\Schema;
    use yii\db\Migration;

    class m140923_142517_rbac_manufacturer_user_permissions extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;
            $endyMed = $auth->getRole(User::ROLE_ENDY);

            $viewManufacturer = $auth->createPermission('viewManufacturer');
            $viewManufacturer->description = 'View Sales User';

            $listManufacturers = $auth->createPermission('listManufacturers');
            $listManufacturers->description = 'List Sales Users';

            $createManufacturers = $auth->createPermission('createManufacturer');
            $createManufacturers->description = 'Create Sales User';

            $updateManufacturer = $auth->createPermission('updateManufacturer');
            $updateManufacturer->description = 'Update Sales User';

            $deleteManufacturer = $auth->createPermission('deleteManufacturer');
            $deleteManufacturer->description = 'Delete Sales User';

            $manufacturerAccessRule = new \app\rbac\AccessToManufacturerRule();
            $auth->add($manufacturerAccessRule);

            $viewManufacturer->ruleName = $manufacturerAccessRule->name;
            $updateManufacturer->ruleName = $manufacturerAccessRule->name;
            $deleteManufacturer->ruleName = $manufacturerAccessRule->name;

            $auth->add($viewManufacturer);
            $auth->add($listManufacturers);
            $auth->add($createManufacturers);
            $auth->add($updateManufacturer);
            $auth->add($deleteManufacturer);

            $auth->addChild($endyMed, $viewManufacturer);
            $auth->addChild($endyMed, $listManufacturers);
            $auth->addChild($endyMed, $createManufacturers);
            $auth->addChild($endyMed, $updateManufacturer);
            $auth->addChild($endyMed, $deleteManufacturer);

            $auth->update($endyMed->name, $endyMed);
        }

        public function down()
        {
            echo "m140923_142517_rbac_manufacturer_user_permissions cannot be reverted.\n";

            return false;
        }
    }
