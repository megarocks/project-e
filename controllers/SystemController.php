<?php

    namespace app\controllers;

    use app\helpers\PayPal;
    use app\models\CodeRequestForm;
    use app\models\PoSystemModel;
    use app\models\User;
    use Yii;
    use app\models\System;
    use yii\filters\AccessControl;
    use yii\helpers\Json;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
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
                            'actions' => ['index', 'view', 'list', 'view-by-code', 'create', 'assign', 'unassign'],
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
         * @return mixed
         */
        public function actionIndex()
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            return $this->render('index-' . $user->role);

        }

        /**
         * Displays a single Systems model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id)
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            return $this->render('view-' . $user->role, [
                    'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates new system
         *
         * @return string|\yii\web\Response
         */
        public function actionCreate()
        {
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
        }

        /**
         * Assigns System to Purchase Order
         *
         * @param $id
         * @return string|\yii\web\Response
         */
        public function actionAssign($id)
        {
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
        }

        /**
         * Un-assigns system from purchase order
         *
         * @param $id
         * @return \yii\web\Response
         */
        public function actionUnassign($id)
        {
            /*@var $model System*/
            $model = $this->findModel($id);

            $model->purchaseOrder->system_sn = null;
            if ($model->purchaseOrder->save()) {
                $model->resetLockingParams();
                $model->save();
            }

            return $this->redirect('/system/' . $model->id);
        }

        /**
         * Returns json array with list of systems
         *
         * @param string|null $fields
         */
        public function actionList($fields = null)
        {

            $systems = System::find()->all();

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
                    $s['next_lock_date'] = $system->next_lock_date;
                    $s['current_code'] = $system->current_code;
                    $s['login_code'] = $system->login_code;
                    $s['npl'] = isset($system->purchaseOrder) ? $system->purchaseOrder->npl : null;
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

        public function actionViewByCode()
        {
            $loginCode = Yii::$app->session->get('loginCode');
            if (!is_null($loginCode)) {
                $model = System::getByLoginCode($loginCode);

                //D($model->lockingDates,true);
                return $this->render('view-enduser', [
                    'model' => $model,
                    'po'    => $model->purchaseOrder,
                ]);
            } else {
                throw new NotFoundHttpException;
            }
        }

    }
