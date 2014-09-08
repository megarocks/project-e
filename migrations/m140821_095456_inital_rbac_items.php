<?php

    use app\models\User;
    use app\rbac\AccessToEndUserRule;
    use yii\db\Schema;
    use yii\db\Migration;

    class m140821_095456_inital_rbac_items extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            //ROLES
            $sales = $auth->createRole(User::ROLE_SALES);
            $manufacturer = $auth->createRole(User::ROLE_MAN);
            $endyMed = $auth->createRole(User::ROLE_ENDY);
            $distributor = $auth->createRole(User::ROLE_DISTR);
            $endUser = $auth->createRole(User::ROLE_END_USER);

            //PERMISSIONS

            //Operations with users
            $viewDashboard = $auth->createPermission('viewDashboard');
            $viewDashboard->description = 'View Dashboard Screen';

            $listUsers = $auth->createPermission('listUsers');
            $listUsers->description = 'View Users List';

            $viewUser = $auth->createPermission('viewUser');
            $viewUser->description = 'View User Account Details';

            $createUser = $auth->createPermission('createUser');
            $createUser->description = 'Create User Account';

            $updateUser = $auth->createPermission('updateUser');
            $updateUser->description = 'Update User Account';

            $deleteUser = $auth->createPermission('deleteUser');
            $deleteUser->description = 'Delete User Account';

            $updateProfile = $auth->createPermission('updateProfile');
            $updateProfile->description = 'Update Own Profile';

            //Operations with end-users
            $listEndUsers = $auth->createPermission('listEndUsers');
            $listEndUsers->description = 'View EndUsers List';

            $viewEndUser = $auth->createPermission('viewEndUser');
            $viewEndUser->description = 'View EndUser Account Details';

            $createEndUser = $auth->createPermission('createEndUser');
            $createEndUser->description = 'Create EndUser Account';

            $updateEndUser = $auth->createPermission('updateEndUser');
            $updateEndUser->description = 'Update EndUser Account';

            $deleteEndUser = $auth->createPermission('deleteEndUser');
            $deleteEndUser->description = 'Delete EndUser Account';

            //Operations with distributors
            $listDistributors = $auth->createPermission('listDistributors');
            $listDistributors->description = 'View Distributors List';

            $viewDistributor = $auth->createPermission('viewDistributor');
            $viewDistributor->description = 'View Distributor Account Details';

            $createDistributor = $auth->createPermission('createDistributor');
            $createDistributor->description = 'Create Distributor Account';

            $updateDistributor = $auth->createPermission('updateDistributor');
            $updateDistributor->description = 'Update Distributor Account';

            $deleteDistributor = $auth->createPermission('deleteDistributor');
            $deleteDistributor->description = 'Delete Distributor Account';

            //Operations with orders
            $listPurchaseOrders = $auth->createPermission('listPurchaseOrders');
            $listPurchaseOrders->description = 'View PurchaseOrders List';

            $viewPurchaseOrder = $auth->createPermission('viewPurchaseOrder');
            $viewPurchaseOrder->description = 'View PurchaseOrder Details';

            $createPurchaseOrder = $auth->createPermission('createPurchaseOrder');
            $createPurchaseOrder->description = 'Create PurchaseOrder';

            $updatePurchaseOrder = $auth->createPermission('updatePurchaseOrder');
            $updatePurchaseOrder->description = 'Update PurchaseOrder';

            $deletePurchaseOrder = $auth->createPermission('deletePurchaseOrder');
            $deletePurchaseOrder->description = 'Delete PurchaseOrder';

            //Operations with payments
            $listPayments = $auth->createPermission('listPayments');
            $listPayments->description = 'View Payments List';

            $viewPayment = $auth->createPermission('viewPayment');
            $viewPayment->description = 'View Payment Details';

            $createPayment = $auth->createPermission('createPayment');
            $createPayment->description = 'Create Payment';

            $updatePayment = $auth->createPermission('updatePayment');
            $updatePayment->description = 'Update Payment';

            $deletePayment = $auth->createPermission('deletePayment');
            $deletePayment->description = 'Delete Payment';

            $purchaseCode = $auth->createPermission('purchaseCode');
            $purchaseCode->description = 'Purchase Code';

            //Operations with systems
            $listSystems = $auth->createPermission('listSystems');
            $listSystems->description = 'View Systems List';

            $viewSystem = $auth->createPermission('viewSystem');
            $viewSystem->description = 'View System Details';

            $createSystem = $auth->createPermission('createSystem');
            $createSystem->description = 'Create System';

            $updateSystem = $auth->createPermission('updateSystem');
            $updateSystem->description = 'Update System';

            $deleteSystem = $auth->createPermission('deleteSystem');
            $deleteSystem->description = 'Delete System';

            $assignSystem = $auth->createPermission('assignSystem');
            $assignSystem->description = 'Assign System';

            $unAssignSystem = $auth->createPermission('unAssignSystem');
            $unAssignSystem->description = 'unAssignSystem System';

            //RULES

            $endUserAccessRule = new AccessToEndUserRule;
            $auth->add($endUserAccessRule);
            $viewEndUser->ruleName = $endUserAccessRule->name;
            $updateEndUser->ruleName = $endUserAccessRule->name;
            $deleteEndUser->ruleName = $endUserAccessRule->name;


            //ADDING OPERATIONS
            $auth->add($viewDashboard);

            $auth->add($listUsers);
            $auth->add($viewUser);
            $auth->add($createUser);
            $auth->add($updateUser);
            $auth->add($deleteUser);
            $auth->add($updateProfile);

            $auth->add($listEndUsers);
            $auth->add($viewEndUser);
            $auth->add($createEndUser);
            $auth->add($updateEndUser);
            $auth->add($deleteEndUser);

            $auth->add($listDistributors);
            $auth->add($viewDistributor);
            $auth->add($createDistributor);
            $auth->add($updateDistributor);
            $auth->add($deleteDistributor);

            $auth->add($listPurchaseOrders);
            $auth->add($viewPurchaseOrder);
            $auth->add($createPurchaseOrder);
            $auth->add($updatePurchaseOrder);
            $auth->add($deletePurchaseOrder);

            $auth->add($listPayments);
            $auth->add($viewPayment);
            $auth->add($createPayment);
            $auth->add($updatePayment);
            $auth->add($deletePayment);
            $auth->add($purchaseCode);

            $auth->add($listSystems);
            $auth->add($viewSystem);
            $auth->add($createSystem);
            $auth->add($updateSystem);
            $auth->add($deleteSystem);
            $auth->add($assignSystem);
            $auth->add($unAssignSystem);


            //ADDING ROLES

            $auth->add($sales);
            $auth->add($manufacturer);
            $auth->add($endyMed);
            $auth->add($distributor);
            $auth->add($endUser);


            //ASSIGNING OPERATIONS TO ROLES
            //root
            $auth->addChild($endyMed, $viewDashboard);
            $auth->addChild($endyMed, $updateProfile);

            $auth->addChild($endyMed, $listUsers);
            $auth->addChild($endyMed, $createUser);
            $auth->addChild($endyMed, $viewUser);
            $auth->addChild($endyMed, $updateUser);
            $auth->addChild($endyMed, $deleteUser);


            $auth->addChild($endyMed, $listEndUsers);
            $auth->addChild($endyMed, $createEndUser);
            $auth->addChild($endyMed, $viewEndUser);
            $auth->addChild($endyMed, $updateEndUser);
            $auth->addChild($endyMed, $deleteEndUser);

            $auth->addChild($endyMed, $listDistributors);
            $auth->addChild($endyMed, $createDistributor);
            $auth->addChild($endyMed, $viewDistributor);
            $auth->addChild($endyMed, $updateDistributor);
            $auth->addChild($endyMed, $deleteDistributor);

            $auth->addChild($endyMed, $listSystems);
            $auth->addChild($endyMed, $createSystem);
            $auth->addChild($endyMed, $updateSystem);
            $auth->addChild($endyMed, $viewSystem);
            $auth->addChild($endyMed, $deleteSystem);
            $auth->addChild($endyMed, $assignSystem);
            $auth->addChild($endyMed, $unAssignSystem);

            $auth->addChild($endyMed, $listPurchaseOrders);
            $auth->addChild($endyMed, $createPurchaseOrder);
            $auth->addChild($endyMed, $viewPurchaseOrder);
            $auth->addChild($endyMed, $updatePurchaseOrder);
            $auth->addChild($endyMed, $deletePurchaseOrder);

            $auth->addChild($endyMed, $listPayments);
            $auth->addChild($endyMed, $createPayment);
            $auth->addChild($endyMed, $purchaseCode);
            $auth->addChild($endyMed, $updatePayment);
            $auth->addChild($endyMed, $viewPayment);
            $auth->addChild($endyMed, $deletePayment);

            //sales
            $auth->addChild($sales, $updateProfile);
            $auth->addChild($sales, $viewDashboard);

            $auth->addChild($sales, $listEndUsers);
            $auth->addChild($sales, $createEndUser);
            $auth->addChild($sales, $viewEndUser);
            $auth->addChild($sales, $updateEndUser);
            $auth->addChild($sales, $deleteEndUser);

            $auth->addChild($sales, $listDistributors);
            $auth->addChild($sales, $createDistributor);
            $auth->addChild($sales, $viewDistributor);
            $auth->addChild($sales, $updateDistributor);
            $auth->addChild($sales, $deleteDistributor);

            $auth->addChild($sales, $listPurchaseOrders);
            $auth->addChild($sales, $createPurchaseOrder);
            $auth->addChild($sales, $viewPurchaseOrder);
            $auth->addChild($sales, $updatePurchaseOrder);
            $auth->addChild($sales, $deletePurchaseOrder);

            //manufacturer
            $auth->addChild($manufacturer, $updateProfile);
            $auth->addChild($manufacturer, $viewDashboard);

            $auth->addChild($manufacturer, $listSystems);
            $auth->addChild($manufacturer, $createSystem);
            $auth->addChild($manufacturer, $updateSystem);
            $auth->addChild($manufacturer, $viewSystem);
            $auth->addChild($manufacturer, $deleteSystem);
            $auth->addChild($manufacturer, $assignSystem);

            //distributor
            $auth->addChild($distributor, $updateProfile);
            $auth->addChild($distributor, $viewDashboard);

            $auth->addChild($distributor, $listEndUsers);
            $auth->addChild($distributor, $createEndUser);
            $auth->addChild($distributor, $viewEndUser);
            $auth->addChild($distributor, $updateEndUser);

            $auth->addChild($distributor, $listSystems);
            $auth->addChild($distributor, $viewSystem);

            //end-user
            $auth->addChild($endUser, $updateProfile);
            $auth->addChild($endUser, $viewDashboard);
            $auth->addChild($endUser, $viewSystem);

            $auth->addChild($endUser, $purchaseCode);

            //ASSIGNING ROLES TO USER RECORDS
            $auth->assign($endyMed, 1);
        }

        public function down()
        {
            echo "m140821_095456_inital_rbac_items cannot be reverted.\n";

            return false;
        }
    }
