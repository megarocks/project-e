<?php

    namespace app\controllers;

    use app\models\User;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\helpers\Json;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\web\UnauthorizedHttpException;
    use Yii;

    /**
     *UserController implements CRUD actions for User model
     */
    class UserController extends Controller
    {
        public function behaviors()
        {
            return [
                'verbs' => [
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
                            'actions' => ['index', 'list', 'view', 'create', 'update', 'profile'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        protected function findModel($id)
        {
            if (($model = User::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        public function actionIndex()
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            if ($user->hasRole(User::ROLE_ENDY)) {
                return $this->render('index-' . User::ROLE_ENDY);
            } else {
                throw new UnauthorizedHttpException;
            }
        }

        public function actionList()
        {
            $users = User::find()->all();
            $result = [];

            /** @var User $user */
            foreach ($users as $user) {
                $u['id'] = $user->id;
                $u['first_name'] = $user->first_name;
                $u['last_name'] = $user->last_name;
                $u['email'] = $user->email;
                $u['role'] = $user->getRole();
                $u['created_at'] = date('M j Y', strtotime($user->created_at));
                $result[] = $u;
            }
            echo(Json::encode($result));
        }

        public function actionView($id)
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            if ($user->hasRole(User::ROLE_ENDY)) {
                return $this->render('view-' . User::ROLE_ENDY, [
                        'model' => $this->findModel($id),
                    ]);
            } else {
                throw new UnauthorizedHttpException;
            }
        }

        public function actionCreate()
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            if ($user->hasRole(User::ROLE_ENDY)) {
                /**@var User $model */
                $model = new User();
                $model->scenario = 'create';
                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $model->load($request);
                    if ($model->registerAccount()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        return $this->render('create-' . User::ROLE_ENDY, ['model' => $model]);
                    }
                } else {
                    return $this->render('create-' . User::ROLE_ENDY, ['model' => $model]);
                }
            } else {
                throw new UnauthorizedHttpException;
            }
        }

        public function actionUpdate($id)
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            if ($user->hasRole(User::ROLE_ENDY)) {
                /**@var User $model */
                $model = $this->findModel($id);
                $model->scenario = 'update';
                //$model->roleField = $model->role;

                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $model->load($request);
                    if ($model->updateAccount()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        return $this->render('update-' . User::ROLE_ENDY, ['model' => $model]);
                    }
                } else {
                    return $this->render('update-' . User::ROLE_ENDY, ['model' => $model]);
                }
            } else {
                throw new UnauthorizedHttpException;
            }
        }

        public function actionProfile()
        {
            echo "User own profile management soon will be here";
        }
    }