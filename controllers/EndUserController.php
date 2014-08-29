<?php

    namespace app\controllers;

    use app\models\Country;
    use app\models\User;
    use Yii;
    use app\models\EndUser;
    use yii\filters\AccessControl;
    use yii\helpers\Json;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * EndusersController implements the CRUD actions for EndUsers model.
     */
    class EndUserController extends Controller
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
                            'actions' => ['index', 'view', 'create', 'update', 'list', 'dynamic'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Finds the EndUsers model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return EndUser the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = EndUser::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        /**
         * Lists all EndUser models.
         * @return mixed
         */
        public function actionIndex()
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            return $this->render('index-' . $user->role);
        }

        /**
         * Displays a single EndUsers model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id)
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;
            $model = $this->findModel($id);

            return $this->render('view-' . $user->role, ['model' => $model]);

        }

        /**
         * Creates a new EndUsers model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            /**@var EndUser $model */
            $model = new EndUser();

            $request = Yii::$app->request->post();

            if (!empty($request)) {
                $model->load($request);
                if ($model->registerEndUser()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('create-' . $user->role, [
                            'model' => $model,
                    ]);
                }
            } else {
                return $this->render('create-' . $user->role, [
                        'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing EndUser model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id)
        {

            /**@var User $user */
            $user = Yii::$app->user->identity;
            /**@var EndUser $model */
            $model = $this->findModel($id);

            $request = Yii::$app->request->post();

            if (!empty($request)) {
                $model->load($request);
                if ($model->updateEndUser()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('update-' . $user->role, [
                            'model' => $model,
                    ]);
                }
            } else {
                return $this->render('update-' . $user->role, [
                        'model' => $model,
                ]);
            }
        }

        /**
         * Returns json array with list of endUsers
         *
         * @param null $fields
         * @return string
         */
        public function actionList($fields = null)
        {
            $endUsers = EndUser::find()->all();
            $result = [];

            if ($fields) {
                $specifiedFields = explode(",", $fields);
                /**@var $user User */
                foreach ($endUsers as $endUser) {
                    $eu = null;
                    foreach ($specifiedFields as $field) {
                        if ($field != '') {
                            $eu[$field] = $endUser[$field];
                        }
                    }
                    if (!is_null($eu)) {
                        $result[] = $eu;
                    }
                }
            } else {
                /**@var $endUser EndUser */
                foreach ($endUsers as $endUser) {
                    $eu['id'] = $endUser->id;
                    $eu['title'] = $endUser->title;
                    $eu['email'] = $endUser->email;
                    $eu['country'] = isset($endUser->country) ? $endUser->country->name : null;
                    $eu['created_at'] = date('M d, Y h:i A', strtotime($endUser->created_at));
                    $result[] = $eu;
                }
            }
            echo(Json::encode($result));
        }

        /**
         * Returns json string with endUsers filtered by country
         * used for dependent dropdowns
         */
        public function actionDynamic()
        {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                if ($parents != null) {
                    $countryId = $parents[0];
                    $country = Country::findOne(['id_countries' => $countryId]);
                    $endUsers = $country->endUsers;
                    $out = [];
                    $res = [];
                    foreach ($endUsers as $eu) {
                        $res['id'] = $eu->id;
                        $res['name'] = $eu->title;
                        $out[] = $res;
                    }
                    echo Json::encode(['output' => $out, 'selected' => '']);
                    return;
                }
            }
            echo Json::encode(['output' => '', 'selected' => '']);
        }
    }
