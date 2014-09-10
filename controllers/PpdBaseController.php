<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 9/8/14
     * Time: 11:51 AM
     */

    namespace app\controllers;


    use app\models\PpdBaseModel;
    use yii\base\Exception;
    use yii\db\ActiveRecord;
    use yii\helpers\Json;
    use yii\web\Controller;
    use Yii;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;

    /**
     * Class PpdBaseController
     * @package app\controllers
     *
     * @property $modelName ActiveRecord
     */
    class PpdBaseController extends Controller
    {

        public $modelName;

        /**
         * Returns json array with models
         *
         * @internal param null $fields gives capability to specify required fields. If null will return default set
         * @param $fields
         * @return string
         */
        public function actionList($fields = null)
        {
            /**
             * @var $className PpdBaseModel
             */
            $className = $this->modelName;

            $models = $className::findAllFiltered();

            $result = [];
            if ($fields) {
                $specField = explode(",", $fields);
                foreach ($models as $model) {
                    $m = null;
                    foreach ($specField as $field) {
                        if ($field != "") {
                            //get field from model and set same field for temp variable
                            try {
                                $m[$field] = $model[$field];
                            } catch (Exception $e) {
                                $m[$field] = $e->getName(); //TODO Possibly better to set null in production mode
                            }
                        }
                    }
                    if (!is_null($m)) {
                        $result[] = $m;
                    }
                }
            } else {
                foreach ($models as $model) {
                    $result[] = $model->toArray();
                }
            }
            return (Json::encode($result));
        }

        /**
         * @param $id
         * @return mixed
         * @throws \yii\web\NotFoundHttpException
         */
        protected function findModel($id)
        {
            $reflectionClass = new \ReflectionClass($this->modelName);
            $modelClassFulName = $reflectionClass->getName();

            $model = $modelClassFulName::findOne($id);

            if (!is_null($model)) {
                return $model;
            } else {
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
            }
        }

        /**
         * Renders view with list of models
         *
         * @return string
         * @throws \yii\web\ForbiddenHttpException
         */
        public function actionIndex()
        {
            $reflectionClass = new \ReflectionClass($this->modelName);
            $modelClassShortName = $reflectionClass->getShortName();

            if (Yii::$app->user->can('list' . $modelClassShortName . 's')) {

                $user = Yii::$app->user->identity;

                return $this->render('index-' . $user->role);

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Renders view with single model details
         *
         * @param $id
         * @return string
         * @throws \yii\web\ForbiddenHttpException
         */
        public function actionView($id)
        {
            $reflectionClass = new \ReflectionClass($this->modelName);
            $modelClassShortName = $reflectionClass->getShortName();

            if (Yii::$app->user->can('view' . $modelClassShortName, ['modelId' => $id])) {

                $user = Yii::$app->user->identity;
                $model = $this->findModel($id);

                return $this->render('view-' . $user->role, ['model' => $model]);

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         * Renders view with create form
         *
         * @return string|\yii\web\Response
         * @throws \yii\web\ForbiddenHttpException
         */
        public function actionCreate()
        {

            $reflectionClass = new \ReflectionClass($this->modelName);
            $modelClassShortName = $reflectionClass->getShortName();

            if (Yii::$app->user->can('create' . $modelClassShortName)) {
                $user = Yii::$app->user->identity;


                $model = $reflectionClass->newInstance();

                $request = Yii::$app->request->post();
                if (!empty($request)) {
                    $model->load($request);
                    if ($model->createModel()) {
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
         * Renders model update form
         *
         * @param $id
         * @return string|\yii\web\Response
         * @throws \yii\web\ForbiddenHttpException
         */
        public function actionUpdate($id)
        {
            $reflectionClass = new \ReflectionClass($this->modelName);
            $modelClassShortName = $reflectionClass->getShortName();

            if (Yii::$app->user->can('update' . $modelClassShortName, ['modelId' => $id])) {

                $user = Yii::$app->user->identity;

                $model = $this->findModel($id);

                $request = Yii::$app->request->post();

                if (!empty($request)) {
                    $model->load($request);
                    if ($model->updateModel()) {
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

    }