<?php

    namespace app\controllers;

    use app\helpers\PayPal;
    use app\models\CodeRequestForm;
    use app\models\EndUser;
    use app\models\PoSystemModel;
    use app\models\PurchaseOrder;
    use app\models\User;
    use Yii;
    use app\models\System;
    use yii\filters\AccessControl;
    use yii\helpers\Json;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * SystemsController implements the CRUD actions for Systems model.
     */
    class SystemController extends Controller
    {
        public function behaviors()
        {
            return [
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['post'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow'   => true,
                            'actions' => ['index', 'view', 'list', 'view-system', 'create', 'assign', 'unassign'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Finds the Systems model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return System the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = System::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        /**
         * Lists all Systems models.
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionIndex()
        {
            if (Yii::$app->user->can('listSystems')) {
                /**@var User $user */
                $user = Yii::$app->user->identity;

                return $this->render('index-' . $user->role);

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Displays a single Systems model.
         * @param integer $id
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionView($id)
        {
            if (Yii::$app->user->can('viewSystem', ['systemId' => $id])) {
                /**@var User $user */
                $user = Yii::$app->user->identity;

                return $this->render('view-' . $user->role, [
                        'model' => $this->findModel($id),
                    ]);
            } else {
                throw new ForbiddenHttpException;
            }

        }

        /**
         * Creates new system
         *
         * @throws \yii\web\ForbiddenHttpException
         * @return string|\yii\web\Response
         */
        public function actionCreate()
        {
            if (Yii::$app->user->can('createSystem')) {
                $request = Yii::$app->request->post();
                $userRole = Yii::$app->user->identity->role;

                /**@var $model System */
                $model = new System();

                if (!empty($request)) {
                    $model->load($request);
                    if ($model->registerSystem()) {
                        return $this->redirect('/system/' . $model->id);
                    } else {
                        return $this->render('create-' . $userRole, ['model' => $model]);
                    }
                } else {
                    return $this->render('create-' . $userRole, ['model' => $model]);
                }

            } else {
                throw new ForbiddenHttpException;
            }

        }

        /**
         * Assigns System to Purchase Order
         *
         * @param $id
         * @throws \yii\web\ForbiddenHttpException
         * @return string|\yii\web\Response
         */
        public function actionAssign($id)
        {
            if (Yii::$app->user->can('assignSystem', ['systemId' => $id])) {
                $request = Yii::$app->request->post();
                $model = new PoSystemModel();
                $system = $this->findModel($id);
                $model->system_sn = $system->sn;
                if (!empty($request)) {
                    $model->load($request);
                    if ($model->assign()) {
                        $this->redirect(['view', 'id' => $model->system->id]);
                    } else {
                        return $this->render('assign-form', ['model' => $model]);
                    }
                } else {
                    return $this->render('assign-form', ['model' => $model]);
                }

            } else {
                throw new ForbiddenHttpException;
            }

        }

        /**
         * Un-assigns system from purchase order
         *
         * @param $id
         * @throws \yii\web\ForbiddenHttpException
         * @return \yii\web\Response
         */
        public function actionUnassign($id)
        {
            if (Yii::$app->user->can('unAssignSystem', ['systemId' => $id])) {
                /*@var $model System*/
                $model = $this->findModel($id);

                $model->purchaseOrder->system_sn = null;
                if ($model->purchaseOrder->save()) {
                    $model->resetLockingParams();
                    $model->save();
                }

                return $this->redirect('/system/' . $model->id);

            } else {
                throw new ForbiddenHttpException;
            }

        }

        /**
         * Returns json array with list of systems
         *
         * @param string|null $fields
         */
        public function actionList($fields = null)
        {

            $systems = $this->getSystemsListForCurrentUser();

            $result = [];

            if ($fields) {
                $specifiedFields = explode(",", $fields);
                /**@var $system System */
                foreach ($systems as $system) {
                    $s = null;
                    foreach ($specifiedFields as $field) {
                        if ($field != '') {
                            $s[$field] = $system[$field];
                        }
                    }
                    if (!is_null($s)) {
                        $result[] = $s;
                    }
                }
            } else {
                /**@var System $system */
                foreach ($systems as $system) {
                    $s['id'] = $system->id;
                    $s['sn'] = $system->sn;
                    $s['status'] = $system->status;
                    $s['po_num'] = isset($system->purchaseOrder) ? $system->purchaseOrder->po_num : null;
                    $s['next_lock_date'] = isset($system->next_lock_date) ? date('M d, Y', strtotime($system->next_lock_date)) : null;
                    $s['init_lock_date'] = isset($system->init_lock_date) ? date('M d, Y', strtotime($system->init_lock_date)) : null;
                    $s['current_code'] = $system->current_code;
                    $s['login_code'] = $system->login_code;
                    $s['dtpl'] = isset($system->purchaseOrder) ? $system->purchaseOrder->dtpl : null;
                    $s['ctpl'] = isset($system->purchaseOrder) ? $system->purchaseOrder->ctpl : null;
                    $s['created_at'] = date('M d, Y h:i A', strtotime($system->created_at));
                    $s['updated_at'] = date('M d, Y h:i A', strtotime($system->created_at));
                    $s['country'] = isset($system->purchaseOrder) ? $system->purchaseOrder->country : null;
                    $s['distributor'] = isset($system->purchaseOrder) ? $system->purchaseOrder->distributor : null;
                    $s['endUser'] = isset($system->purchaseOrder) ? $system->purchaseOrder->endUser : null;
                    $result[] = $s;
                }
            }

            echo(Json::encode($result));
        }

        /**
         * This action is especially for endusers
         * It takes care to find out user system and display it on view
         *
         * @throws \yii\web\ForbiddenHttpException
         * @return \yii\web\Response
         */
        public function actionViewSystem()
        {
            if (Yii::$app->user->can('viewSystem')) {
                $system = $this->findSystemForEndUser(Yii::$app->user->id);

                if (!is_null($system)) {
                    $this->redirect(['view', 'id' => $system->id]);
                }
            } else {
                throw new ForbiddenHttpException;
            }
        }

        private function findSystemForEndUser($userId)
        {
            $system = null;

            //find end user assigned to currently logged in user
            /**
             * @var $endUser EndUser
             */
            $endUser = EndUser::findOne(['user_id' => $userId]);

            //find po assigned to EU
            /**
             * @var $po PurchaseOrder
             */
            if ($endUser) {
                $po = $endUser->purchaseOrder;
                if ($po) {
                    $system = $po->system;
                }
            }

            return $system;
        }

        /**
         * Filters list of models which current user can see in the list
         * returns only those ones which user "CAN" view
         * condition is defined in access rule
         *
         * @return array
         */
        private function getSystemsListForCurrentUser()
        {
            $filteredSystems = [];
            foreach (System::find()->all() as $system) {
                if (Yii::$app->user->can('viewSystem', ['systemId' => $system->id])) {
                    $filteredSystems[] = $system;
                }
            }

            return $filteredSystems;
        }

    }
