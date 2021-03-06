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
    class DistributorController extends PpdBaseController
    {

        public $modelName = 'app\models\Distributor';

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
                            'actions' => ['index', 'view', 'create', 'update', 'list', 'dynamic', 'delete'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
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
                    $country = Country::findOne(['id' => $countryId]);
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
                    if (count($out) > 0) {
                        echo Json::encode(['output' => $out, 'selected' => $out[0]['id']]);
                    } else {
                        echo Json::encode(['output' => $out, 'selected' => '']);
                    }

                }
            } else {
                //if country is not specified return empty list
                echo Json::encode(['output' => '', 'selected' => '']);
            }

        }

        public function actionCreate()
        {

            if (Yii::$app->user->can('createDistributor')) {
                $user = Yii::$app->user->identity;
                /**@var Distributor $distributor */
                $distributor = new Distributor();

                $passForNewUser = Yii::$app->security->generateRandomString(6);
                $relatedUser = new User(
                    [
                        'roleField'       => User::ROLE_DISTR,
                        'password'        => $passForNewUser,
                        'password_repeat' => $passForNewUser,
                    ]);

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $distributor->load($request);
                    $relatedUser->load($request);

                    if ($relatedUser->createModel()) {
                        $distributor->user_id = $relatedUser->id;
                        if ($distributor->createModel()) {
                            return $this->redirect(['view', 'id' => $distributor->id]);
                        }
                    } else {
                        return $this->render('create-' . $user->role,
                            [
                                'distributor' => $distributor,
                                'relatedUser' => $relatedUser,
                            ]);
                    }
                } else {
                    return $this->render('create-' . $user->role, [
                        'distributor' => $distributor,
                        'relatedUser' => $relatedUser,
                    ]);
                }
            } else {
                throw new ForbiddenHttpException;
            }
        }

        public function actionUpdate($id)
        {

            if (Yii::$app->user->can('updateDistributor', ['modelId' => $id])) {

                $user = Yii::$app->user->identity;
                /**@var Distributor $distributor */
                $distributor = $this->findModel($id);
                /**@var User $relatedUser */
                $relatedUser = $distributor->user;

                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $distributor->load($request);
                    $relatedUser->load($request);

                    if ($relatedUser->updateModel() && $distributor->updateModel()) {
                        return $this->redirect(['view', 'id' => $distributor->id]);
                    } else {
                        return $this->render('update-' . $user->role, ['distributor' => $distributor, 'relatedUser' => $relatedUser]);
                    }
                } else {
                    return $this->render('update-' . $user->role, ['distributor' => $distributor, 'relatedUser' => $relatedUser]);
                }

            } else {
                throw new ForbiddenHttpException;
            }
        }

    }
