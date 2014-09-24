<?php

    namespace app\rbac;

    use app\models\Distributor;
    use app\models\User;
    use yii\helpers\ArrayHelper;
    use yii\rbac\Item;
    use yii\rbac\Rule;
    use Yii;

    class AccessToDistributorRule extends Rule
    {

        public $name = 'isCapableToAccessDistributor';

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
                return true;
            } elseif ($role == User::ROLE_SALES) {
                return true;
            } elseif ($role == User::ROLE_DISTR) {
                $currentDistributor = Distributor::findOne(['user_id' => $user]);
                $requestedDistributor = Distributor::findOne(['id' => $params['modelId']]);

                return $currentDistributor->id == $requestedDistributor->id;
            } else {
                return false;
            }
        }
    }