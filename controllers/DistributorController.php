<?php

    namespace app\controllers;

    use app\models\Country;
    use app\models\DistributorCountry;
    use Yii;
    use app\models\Distributor;
    use yii\filters\AccessControl;
    use yii\web\Controller;
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
         * Lists all Distributors models.
         * @return mixed
         */
        public function actionIndex()
        {
            return $this->render('index');
        }

        /**
         * Displays a single Distributors model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id)
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        /**
         * Creates a new Distributors model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            //prepare model
            $model = new Distributor();
            //get post request into variable
            $request = Yii::$app->request->post();
            //if request is not empty
            if (!empty($request)) {
                //load data into model
                $model->load($request);
                //call distributor registering logic and if it returns true
                if ($model->registerDistributor()) {
                    //redirect browser to view action
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    //if distributor registering returned false - re-render 'create' page using current model
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            } else {
                // if request is empty - render 'create' screen using blank model
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing Distributors model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
            //find model using given id
            $model = $this->findModel($id);
            //get post request into variable
            $request = Yii::$app->request->post();
            //if request is not empty
            if (!empty($request)) {
                //load data into model
                $model->load($request);
                //call distributor updating logic logic and if it returns true
                if ($model->updateDistributor()) {
                    //redirect browser to view action
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    //if distributor updating returned false - re-render 'update' page using current model
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            } else {
                // if request is empty - initialize country_id field
                $model->country_id = $model->getCountryId();

                //render 'update' screen using blank model
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing Distributors model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id)
        {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
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
         * Returns json array with distributors
         *
         * @param null $fields gives capability to specify required fields. If null will return default set
         * @return string
         */
        public function actionList($fields = null)
        {
            //get all distributors into array
            $distributors = Distributor::find()->all();
            //initialize result variuable
            $result = [];
            //check if fields are specified
            if ($fields) {
                //get array with needed fields from specified string
                $specField = explode(",", $fields);
                /** @var $distributor Distributor */
                foreach ($distributors as $distributor) {
                    $d = null;
                    //for each field if it's not empty
                    foreach ($specField as $field) {
                        if ($field != "") {
                            //get field from distributor and set same field for temp variable
                            $d[$field] = $distributor[$field];
                        }
                    }
                    //if temp variable is set
                    if (isset($d)) {
                        //add it to the result array
                        $result[] = $d;
                    }
                }
            } else {
                //if fields are not specified return default set
                /**@var Distributor $distributor */
                foreach ($distributors as $distributor) {
                    $d['id'] = $distributor->id;
                    $d['title'] = $distributor->title;
                    $d['email'] = $distributor->email;;
                    $d['country'] = $distributor->countryName; //TODO return full country object and get it's name after
                    $result[] = $d;
                }
            }
            //return result array in json format
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
    }
