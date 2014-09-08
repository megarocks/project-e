<?php

    namespace app\controllers;

    use app\models\Country;
    use app\models\DistributorCountry;
    use app\models\User;
    use Yii;
    use app\models\Distributor;
    use yii\db\ActiveRecord;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\helpers\Json;

    /**
     * DistributorsController implements the CRUD actions for Distributors model.
     */
    class DistributorController extends Controller
    {
        /**
         * @return array
         */
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
                            'actions' => ['index', 'view', 'create', 'update', 'delete', 'list', 'dynamic'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Finds the Distributors model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Distributor the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = Distributor::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        /**
         * Lists all Distributors models.
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionIndex()
        {
            if (Yii::$app->user->can('listDistributors')) {
                /**@var User $user */
                $user = Yii::$app->user->identity;

                return $this->render('index-' . $user->role);

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Displays a single Distributors model.
         * @param integer $id
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionView($id)
        {
            if (Yii::$app->user->can('viewDistributor', ['distributor_id' => $id])) {
                /**@var User $user */
                $user = Yii::$app->user->identity;
                $model = $this->findModel($id);

                return $this->render('view-' . $user->role, ['model' => $model]);
            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Creates a new Distributors model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionCreate()
        {
            if (Yii::$app->user->can('createDistributor')) {
                /**@var User $user */
                $user = Yii::$app->user->identity;
                /**@var Distributor $model */
                $model = new Distributor();

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $model->load($request);
                    if ($model->registerDistributor()) {
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
         * Updates an existing Distributors model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionUpdate($id)
        {
            if (Yii::$app->user->can('updateDistributor', ['distributorId' => $id])) {
                /**@var User $user */
                $user = Yii::$app->user->identity;
                /**@var Distributor $model */
                $model = $this->findModel($id);

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $model->load($request);
                    if ($model->updateDistributor()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        return $this->render('update-' . $user->role, ['model' => $model]);
                    }
                } else {
                    $model->country_id = $model->getCountryId();

                    return $this->render('update-' . $user->role, ['model' => $model]);
                }
            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Returns json array with distributors
         *
         * @param null $fields gives capability to specify required fields. If null will return default set
         * @return string
         */
        public function actionList($fields = null)
        {
            $distributors = $this->getModelsListForCurrentUser(Distributor::className());
            $result = [];
            if ($fields) {
                $specField = explode(",", $fields);
                /** @var $distributor Distributor */
                foreach ($distributors as $distributor) {
                    $d = null;
                    foreach ($specField as $field) {
                        if ($field != "") {
                            //get field from distributor and set same field for temp variable
                            $d[$field] = $distributor[$field];
                        }
                    }
                    if (!is_null($d)) {
                        $result[] = $d;
                    }
                }
            } else {
                /**@var Distributor $distributor */
                foreach ($distributors as $distributor) {
                    $d['id'] = $distributor->id;
                    $d['title'] = $distributor->title;
                    $d['email'] = $distributor->email;;
                    $d['country'] = $distributor->countryName; //TODO return full country object and get it's name after
                    $result[] = $d;
                }
            }
            echo(Json::encode($result));
        }

        /**
         * Get country specified in "dependent dropdown"
         * Returns json encoded list of distributors assigned to the specified country
         *
         * @param depdrop_parents
         * @return string
         */
        public function actionDynamic()
        {
            //check if value in parent dropdown has been specified
            if (isset($_POST['depdrop_parents'])) {
                //get list of parent dropdowns
                $parents = $_POST['depdrop_parents'];
                if ($parents != null) {
                    //get first value of array with parameters from parent dropdown
                    $countryId = $parents[0];
                    //find a country by the id
                    $country = Country::findOne(['id_countries' => $countryId]);
                    //get list of distributors assigned to found country
                    $distributors = $country->distributors;
                    $out = [];
                    $res = [];
                    //prepare array with found distributors
                    foreach ($distributors as $d) {
                        $res['id'] = $d->id;
                        $res['name'] = $d->title;
                        $out[] = $res;
                    }
                    //return json array with list of distributors
                    echo Json::encode(['output' => $out, 'selected' => '']);
                }
            } else {
                //if country is not specified return empty list
                echo Json::encode(['output' => '', 'selected' => '']);
            }

        }

        /**
         * Checks access of current user to view model. If can - adds to result array
         *
         * @param $modelClass ActiveRecord class
         * @return array
         */
        private function getModelsListForCurrentUser($modelClass)
        {
            /**
             * @var $modelClass ActiveRecord
             * @var $modelClassName string
             */
            $reflectionClass = new \ReflectionClass($modelClass);
            $modelClassName = $reflectionClass->getShortName();
            $filteredModels = [];
            foreach ($modelClass::find()->all() as $model) {
                if (Yii::$app->user->can('view' . $modelClassName, ['modelId' => $model->id])) {
                    $filteredModels[] = $model;
                }
            }

            return $filteredModels;
        }
    }
