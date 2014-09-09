<?php

    use app\models\User;
    use app\rbac\AccessToDistributorRule;
    use app\rbac\AccessToEndUserRule;
    use app\rbac\AccessToPaymentRule;
    use app\rbac\AccessToPurchaseOrderRule;
    use app\rbac\AccessToSystemRule;
    use app\rbac\AccessToUserRule;
    use yii\db\Schema;
    use yii\db\Migration;

    class m140909_094111_rbac_entries_access_rules extends Migration
    {
        public function up()
        {
            $auth = \Yii::$app->authManager;

            //ACCESS RULES
            $userAccessRule = new AccessToUserRule();
            $auth->add($userAccessRule);

            $systemAccessRule = new AccessToSystemRule();
            $auth->add($systemAccessRule);

            $purchaseOrderAccessRule = new AccessToPurchaseOrderRule();
            $auth->add($purchaseOrderAccessRule);

            $paymentAccessRule = new AccessToPaymentRule();
            $auth->add($paymentAccessRule);

            $endUserAccessRule = new AccessToEndUserRule();
            $auth->add($endUserAccessRule);

            $distributorAccessRule = new AccessToDistributorRule();
            $auth->add($distributorAccessRule);

            //ASSIGNING RULES TO PERMISSIONS

            $viewUser = $auth->getPermission('viewUser');
            $updateUser = $auth->getPermission('updateUser');
            $deleteUser = $auth->getPermission('deleteUser');

            $viewUser->ruleName = $userAccessRule->name;
            $updateUser->ruleName = $userAccessRule->name;
            $deleteUser->ruleName = $userAccessRule->name;


            $viewEndUser = $auth->getPermission('viewEndUser');
            $updateEndUser = $auth->getPermission('updateEndUser');
            $deleteEndUser = $auth->getPermission('deleteEndUser');

            $viewEndUser->ruleName = $endUserAccessRule->name;
            $updateEndUser->ruleName = $endUserAccessRule->name;
            $deleteEndUser->ruleName = $endUserAccessRule->name;


            $viewDistributor = $auth->getPermission('viewDistributor');
            $updateDistributor = $auth->getPermission('updateDistributor');
            $deleteDistributor = $auth->getPermission('deleteDistributor');

            $viewDistributor->ruleName = $distributorAccessRule->name;
            $updateDistributor->ruleName = $distributorAccessRule->name;
            $deleteDistributor->ruleName = $distributorAccessRule->name;


            $viewPurchaseOrder = $auth->getPermission('viewPurchaseOrder');
            $updatePurchaseOrder = $auth->getPermission('updatePurchaseOrder');
            $deletePurchaseOrder = $auth->getPermission('deletePurchaseOrder');

            $viewPurchaseOrder->ruleName = $purchaseOrderAccessRule->name;
            $updatePurchaseOrder->ruleName = $purchaseOrderAccessRule->name;
            $deletePurchaseOrder->ruleName = $purchaseOrderAccessRule->name;


            $viewPayment = $auth->getPermission('viewPayment');
            $updatePayment = $auth->getPermission('updatePayment');
            $deletePayment = $auth->getPermission('deletePayment');

            $viewPayment->ruleName = $paymentAccessRule->name;
            $updatePayment->ruleName = $paymentAccessRule->name;
            $deletePayment->ruleName = $paymentAccessRule->name;


            $viewSystem = $auth->getPermission('viewSystem');
            $updateSystem = $auth->getPermission('updateSystem');
            $deleteSystem = $auth->getPermission('deleteSystem');

            $assignSystem = $auth->getPermission('assignSystem');
            $unAssignSystem = $auth->getPermission('unAssignSystem');

            $viewSystem->ruleName = $systemAccessRule->name;
            $updateSystem->ruleName = $systemAccessRule->name;
            $deleteSystem->ruleName = $systemAccessRule->name;
            $assignSystem->ruleName = $systemAccessRule->name;
            $unAssignSystem->ruleName = $systemAccessRule->name;

            //UPDATING PERMISSIONS
            $auth->update($viewUser->name, $viewUser);
            $auth->update($updateUser->name, $updateUser);
            $auth->update($deleteUser->name, $deleteUser);
            $auth->update($viewEndUser->name, $viewEndUser);
            $auth->update($updateEndUser->name, $updateEndUser);
            $auth->update($deleteEndUser->name, $deleteEndUser);
            $auth->update($viewDistributor->name, $viewDistributor);
            $auth->update($updateDistributor->name, $updateDistributor);
            $auth->update($deleteDistributor->name, $deleteDistributor);
            $auth->update($viewPurchaseOrder->name, $viewPurchaseOrder);
            $auth->update($updatePurchaseOrder->name, $updatePurchaseOrder);
            $auth->update($deletePurchaseOrder->name, $deletePurchaseOrder);
            $auth->update($viewPayment->name, $viewPayment);
            $auth->update($updatePayment->name, $updatePayment);
            $auth->update($deletePayment->name, $deletePayment);
            $auth->update($viewSystem->name, $viewSystem);
            $auth->update($updateSystem->name, $updateSystem);
            $auth->update($deleteSystem->name, $deleteSystem);
            $auth->update($assignSystem->name, $assignSystem);
            $auth->update($unAssignSystem->name, $unAssignSystem);


        }

        public function down()
        {
            echo "m140909_094111_rbac_entries_access_rules cannot be reverted.\n";

            return false;
        }
    }
