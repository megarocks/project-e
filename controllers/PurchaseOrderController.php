<?php

    namespace app\controllers;

    use app\models\Country;
    use app\models\PurchaseOrder;
    use app\models\System;
    use app\models\User;
    use Yii;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\helpers\Json;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;
    use yii\web\UnauthorizedHttpException;

    /**
     * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
     */
    class PurchaseOrderController extends Controller
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
                            'actions' => ['index', 'view', 'create', 'update', 'list', 'dynamic-currency'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Finds the PurchaseOrder model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return PurchaseOrder the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = PurchaseOrder::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        /**
         * Renders view with list of PurchaseOrders
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionIndex()
        {
            if (Yii::$app->user->can('listOrders')) {
                /**@var User $user */
                $user = Yii::$app->user->identity;

                return $this->render('index-' . $user->role);

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Displays a single PurchaseOrder model.
         * @param integer $id
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionView($id)
        {
            if (Yii::$app->user->can('viewOrder', ['orderId' => $id])) {
                /**@var User $user */
                $user = Yii::$app->user->identity;
                $model = $this->findModel($id);

                return $this->render('view-' . $user->role, ['model' => $model]);

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Creates a new PurchaseOrder model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionCreate()
        {
            if (Yii::$app->user->can('createOrder')) {
                /**@var User $user */
                $user = Yii::$app->user->identity;

                /**@var PurchaseOrder $model */
                $model = new PurchaseOrder();

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $model->load($request);
                    if ($model->createPurchaseOrder()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        return $this->render('create-' . $user->role, ['model' => $model]);
                    }
                } else {
                    return $this->render('create-' . $user->role, ['model' => $model]);
                }

            } else {
                throw new ForbiddenHttpException;
            }

        }

        /**
         * Updates an existing PurchaseOrder model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionUpdate($id)
        {
            if (Yii::$app->user->can('updateOrder', ['orderId' => $id])) {
                /**@var User $user */
                $user = Yii::$app->user->identity;

                /**@var PurchaseOrder $model */
                $model = $this->findModel($id);

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $model->load($request);
                    if ($model->updatePurchaseOrder()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        return $this->render('update-' . $user->role, ['model' => $model]);
                    }
                } else {
                    return $this->render('update-' . $user->role, ['model' => $model]);
                }
            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Return list of PurchaseOrders in json format
         */
        public function actionList($fields = null)
        {
            $orders = $this->getOrdersListForCurrentUser();
            $result = [];
            //if fields are defined in request
            if (!is_null($fields)) {
                $specField = explode(",", $fields);
                /** @var $order PurchaseOrder */
                foreach ($orders as $order) {
                    $o = null;
                    foreach ($specField as $field) {
                        if ($field != "") {
                            $o[$field] = $order[$field];
                        }
                    }
                    if (!is_null($o)) {
                        $result[] = $o;
                    }
                }
            } else { //return default fields set if not specified
                /** @var $order PurchaseOrder */
                foreach ($orders as $order) {
                    $o['id'] = $order->id;
                    $o['po_num'] = $order->po_num;
                    $o['created_at'] = date('M d, Y h:i A', strtotime($order->created_at));
                    $o['cpup'] = $order->cpup;
                    $o['dpup'] = $order->dpup;
                    $o['dsp'] = $order->dsp;
                    $o['csp'] = $order->csp;
                    $o['nop'] = $order->nop;
                    $o['distributor'] = isset($order->distributor->title) ? $order->distributor->title : null;
                    $o['country'] = isset($order->country->name) ? $order->country->name : null;
                    $result[] = $o;
                }
            }
            echo(Json::encode($result));
        }

        /**
         * Returns json string with currencies filtered by country
         * used for dependent dropdowns
         */
        public function actionDynamicCurrency()
        {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                if ($parents != null) {
                    $countryId = $parents[0];
                    $country = Country::findOne(['id_countries' => $countryId]);

                    $out = [];

                    $countryCurrency['id'] = $country->currency_code;
                    $countryCurrency['name'] = $country->currency_code;
                    $out[] = $countryCurrency;
                    //if country currency is not USD - add it just in case
                    if ($countryCurrency['id'] != 'USD') {
                        $out[] = [
                            'id'   => 'USD',
                            'name' => 'USD',
                        ];
                    }
                    echo Json::encode(['output' => $out, 'selected' => 'USD']);

                    return;
                }
            }
            echo Json::encode(['output' => '', 'selected' => 'USD']);
        }

        /**
         * Filters list of models which current user can see in the list
         * returns only those ones which user "CAN" view
         * condition is defined in access rule
         *
         * @return array
         */
        private function getOrdersListForCurrentUser()
        {
            $filteredOrders = [];
            foreach (PurchaseOrder::find()->all() as $order) {
                if (Yii::$app->user->can('viewOrder', ['orderId' => $order->id])) {
                    $filteredOrders[] = $order;
                }
            }

            return $filteredOrders;
        }

    }