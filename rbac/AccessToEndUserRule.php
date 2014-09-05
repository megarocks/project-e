<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 9/5/14
     * Time: 1:44 PM
     */

    namespace app\rbac;


    use app\models\Distributor;
    use app\models\User;
    use yii\helpers\ArrayHelper;
    use yii\rbac\Item;
    use yii\rbac\Rule;
    use Yii;

    class AccessToEndUserRule extends Rule
    {

        public $name = 'isCapableToAccessEndUser';

        /**
         * Executes the rule.
         *
         * @param string|integer $user the user ID. This should be either an integer or a string representing
         * the unique identifier of a user. See [[\yii\web\User::id]].
         * @param Item $item the role or permission that this rule is associated with
         * @param array $params parameters passed to [[ManagerInterface::checkAccess()]].
         * @return boolean a value indicating whether the rule permits the auth item it is associated with.
         */
        public function execute($user, $item, $params)
        {
            $role = array_keys(Yii::$app->authManager->getRolesByUser($user))[0]; //get role of user to which this rule is applied
            if ($role == User::ROLE_ENDY) {
                //endymed have access to all endusers
                return true;
            } elseif ($role == User::ROLE_DISTR) {
                //check do this end-user assigned to any from orders of this distributor

                //get distributor
                $distributor = Distributor::findOne(['user_id' => $user]);
                //get all orders of this distributor
                $purchaseOrders = $distributor->purchaseOrders;
                //get array of end-user id's assigned to orders
                $endUsers = [];
                foreach ($purchaseOrders as $purchaseOrder) {
                    $endUsers[] = $purchaseOrder->end_user_id;
                }

                //check if requested end user id is in the the array
                return in_array($params['endUserId'], $endUsers);

            } elseif ($role == User::ROLE_SALES) {
                //sales have access to all end users
                return true;
            } else {
                return false;
            }
        }
    }