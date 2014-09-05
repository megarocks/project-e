<?php

    namespace app\controllers;

    use app\models\User;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\helpers\Json;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
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

        /**
         * Renders view with list of users
         *
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionIndex()
        {
            if (Yii::$app->user->can('listUsers')) {
                /**@var User $user */
                $user = Yii::$app->user->identity;

                return $this->render('index-' . $user->role);

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Displays single User model view
         *
         * @param $id
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionView($id)
        {
            if (Yii::$app->user->can('viewUser', ['userId' => $id])) {
                /**@var User $user */
                $user = Yii::$app->user->identity;
                $model = $this->findModel($id);

                return $this->render('view-' . $user->role, ['model' => $model]);

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Displays user creation form
         *
         * @throws \yii\web\ForbiddenHttpException
         * @return string|\yii\web\Response
         */
        public function actionCreate()
        {
            if (Yii::$app->user->can('createUser')) {
                /**@var User $user */
                $user = Yii::$app->user->identity;
                /**@var User $model */
                $model = new User();

                $model->scenario = 'create';

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $model->load($request);
                    if ($model->registerAccount()) {
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
         * Displays user account update form
         *
         * @param $id
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionUpdate($id)
        {
            if (Yii::$app->user->can('updateUser', ['userId' => $id])) {
                /**@var User $user */
                $user = Yii::$app->user->identity;

                /**@var User $model */
                $model = $this->findModel($id);
                $model->scenario = 'update';

                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $model->load($request);
                    if ($model->updateAccount()) {
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
         * Displays own profile update form
         *
         * @throws \yii\web\ForbiddenHttpException
         * @return mixed
         */
        public function actionProfile()
        {
            if (Yii::$app->user->can('updateProfile')) {
                $model = $this->findModel(Yii::$app->user->id);
                $model->scenario = 'update';
                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $model->load($request);
                    if ($model->updateAccount()) {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Profile data has been updated successfully'));
                        $this->refresh();
                    } else {
                        return $this->render('own-profile', ['model' => $model]);
                    }

                } else {
                    return $this->render('own-profile', ['model' => $model]);
                }

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Returns json array of user accounts
         *
         * return string
         */
        public function actionList($fields = null)
        {
            $users = User::find()->all();
            $result = [];

            if ($fields) {
                $specifiedFields = explode(",", $fields);
                /**@var $user User */
                foreach ($users as $user) {
                    $u = null;
                    foreach ($specifiedFields as $field) {
                        if ($field != '') {
                            $u[$field] = $user[$field];
                        }
                    }
                    if (!is_null($u)) {
                        $result[] = $u;
                    }
                }
            } else {
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
            }
            echo(Json::encode($result));
        }

        /**
         * Filters list of models which current user can see in the list
         * returns only those ones which user "CAN" view
         * condition is defined in access rule
         *
         * @return array
         */
        private function getUsersListForCurrentUser()
        {
            $filteredUsers = [];
            foreach (User::find()->all() as $user) {
                if (Yii::$app->user->can('viewUser', ['userId' => $user->id])) {
                    $filteredUsers[] = $user;
                }
            }

            return $filteredUsers;
        }
    }