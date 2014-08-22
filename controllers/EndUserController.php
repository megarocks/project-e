<?php

    namespace app\controllers;

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
                            'actions' => ['index', 'view', 'create', 'update', 'list'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Lists all EndUser models.
         * @return mixed
         */
        public function actionIndex()
        {
            return $this->render('index');
        }

        /**
         * Displays a single EndUsers model.
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
         * Creates a new EndUsers model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new EndUser();

            $request = Yii::$app->request->post();

            if (!empty($request)) {
                $model->load($request);
                if ($model->registerEndUser()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->render('create', [
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
            $model = $this->findModel($id);
            $request = Yii::$app->request->post();

            if (!empty($request)) {
                $model->load($request);
                if ($model->updateEndUser()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing EndUsers model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id)
        {
            $this->findModel($id)->deleteEndUser();

            return $this->redirect(['index']);
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
         * Returns json array with list of endUsers
         *
         * @return string
         */
        public function actionList()
        {
            $endUsers = EndUser::find()->all();
            $result = [];
            /**@var $endUser EndUser */
            foreach ($endUsers as $endUser) {
                $eu['id'] = $endUser->id;
                $eu['title'] = $endUser->title;
                $eu['email'] = $endUser->email;
                $eu['country'] = isset($endUser->country) ? $endUser->country->name : null;
                $eu['created_at'] = date('M d, Y h:i A', strtotime($endUser->created_at));
                $result[] = $eu;
            }
            echo(Json::encode($result));
        }
    }
