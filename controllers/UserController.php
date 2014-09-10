<?php

    namespace app\controllers;

    use app\models\User;
    use yii\base\Model;
    use yii\db\ActiveRecord;
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
    class UserController extends PpdBaseController
    {
        public $modelName = 'app\models\User';

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
                    if ($model->updateModel()) {
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

    }

