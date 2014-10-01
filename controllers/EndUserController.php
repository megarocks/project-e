<?php

    namespace app\controllers;

    use app\models\Country;
    use app\models\Distributor;
    use app\models\User;
    use Yii;
    use app\models\EndUser;
    use yii\filters\AccessControl;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Json;
    use yii\web\ForbiddenHttpException;
    use yii\filters\VerbFilter;

    /**
     * EndusersController implements the CRUD actions for EndUsers model.
     */
    class EndUserController extends PpdBaseController
    {
        public $modelName = 'app\models\EndUser';

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
         * Returns json string with endUsers filtered by country
         * used for dependent dropdowns
         */
        public function actionDynamic()
        {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                if ($parents != null) {
                    $countryId = $parents[0];
                    $country = Country::findOne(['id' => $countryId]);
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

        public function actionCreate()
        {

            if (Yii::$app->user->can('createEndUser')) {
                $user = Yii::$app->user->identity;

                $endUser = new EndUser();
                $countriesList = ArrayHelper::map(Country::find()->all(), 'id', 'name');

                if ($user->role == User::ROLE_DISTR) {
                    $distributor = Distributor::findOne(['user_id' => $user->id]);
                    $endUser->country_id = $distributor->country_id;
                    $endUser->distributor_id = $distributor->id;
                    $countriesList = [$distributor->country_id => $distributor->country->name];
                }

                $passForNewUser = Yii::$app->security->generateRandomString(6);
                $relatedUser = new User(
                    [
                        'roleField'       => User::ROLE_END_USER,
                        'password'        => $passForNewUser,
                        'password_repeat' => $passForNewUser,
                    ]);

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $endUser->load($request);
                    $relatedUser->load($request);

                    if ($relatedUser->createModel()) {
                        $endUser->user_id = $relatedUser->id;
                        if ($endUser->createModel()) {
                            return $this->redirect(['view', 'id' => $endUser->id]);
                        } else {
                            return $this->render('create-' . $user->role,
                                [
                                    'endUser'       => $endUser,
                                    'relatedUser'   => $relatedUser,
                                    'countriesList' => $countriesList,
                                ]);
                        }
                    } else {
                        return $this->render('create-' . $user->role,
                            [
                                'endUser'     => $endUser,
                                'relatedUser' => $relatedUser,
                                'countriesList' => $countriesList,
                            ]);
                    }
                } else {
                    return $this->render('create-' . $user->role, [
                        'endUser'     => $endUser,
                        'relatedUser' => $relatedUser,
                        'countriesList' => $countriesList,
                    ]);
                }
            } else {
                throw new ForbiddenHttpException;
            }
        }

        public function actionUpdate($id)
        {

            if (Yii::$app->user->can('updateEndUser', ['modelId' => $id])) {

                $user = Yii::$app->user->identity;
                /**@var EndUser $endUser */
                $endUser = $this->findModel($id);
                /**@var User $relatedUser */
                $relatedUser = $endUser->user;
                $countriesList = ArrayHelper::map(Country::find()->all(), 'id', 'name');

                if ($user->role == User::ROLE_DISTR) {
                    $distributor = Distributor::findOne(['user_id' => $user->id]);
                    $countriesList = [$distributor->country_id => $distributor->country->name];
                }

                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $endUser->load($request);
                    $relatedUser->load($request);

                    if ($relatedUser->updateModel() && $endUser->updateModel()) {
                        return $this->redirect(['view', 'id' => $endUser->id]);
                    } else {
                        return $this->render('update-' . $user->role, ['endUser' => $endUser, 'relatedUser' => $relatedUser, 'countriesList' => $countriesList,]);
                    }
                } else {
                    return $this->render('update-' . $user->role, ['endUser' => $endUser, 'relatedUser' => $relatedUser, 'countriesList' => $countriesList,]);
                }

            } else {
                throw new ForbiddenHttpException;
            }
        }
    }
