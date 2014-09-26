<?php

    namespace app\controllers;

    use app\helpers\PayPal;
    use app\models\CodeRequestForm;
    use app\models\EndUser;
    use app\models\PoSystemModel;
    use app\models\PurchaseOrder;
    use app\models\User;
    use Yii;
    use app\models\System;
    use yii\db\ActiveRecord;
    use yii\filters\AccessControl;
    use yii\helpers\Json;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\HttpException;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * SystemsController implements the CRUD actions for Systems model.
     */
    class SystemController extends PpdBaseController
    {

        public $modelName = 'app\models\System';

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
                            'actions' => ['index', 'view', 'list', 'view-system', 'create', 'assign', 'unassign', 'delete', 'update'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Assigns System to Purchase Order
         *
         * @param null $system_id
         * @param null $po_id
         * @throws \yii\web\ForbiddenHttpException
         * @internal param $id
         * @return string|\yii\web\Response
         */
        public function actionAssign($system_id = null, $po_id = null)
        {
            if (Yii::$app->user->can('assignSystem', ['systemId' => $system_id, 'poId' => $po_id])) {
                $request = Yii::$app->request->post();
                $model = new PoSystemModel([
                    'system_id' => $system_id,
                    'po_id'     => $po_id,
                ]);
                /*                $system = $this->findModel($system_id);
                                $model->system_sn = $system->sn;*/
                if (!empty($request)) {
                    $model->load($request);
                    if ($model->assign()) {
                        return $this->goBack();
                    } else {
                        return $this->render('assign-form', ['model' => $model]);
                    }
                } else {
                    return $this->render('assign-form', ['model' => $model]);
                }

            } else {
                throw new ForbiddenHttpException;
            }

        }

        /**
         * Un-assigns system from purchase order
         *
         * @param $id
         * @throws \yii\web\ForbiddenHttpException
         * @return \yii\web\Response
         */
        public function actionUnassign($id)
        {
            if (Yii::$app->user->can('unAssignSystem', ['systemId' => $id])) {
                /*@var $model System*/
                $model = $this->findModel($id);

                if ($model->purchaseOrder) {
                    $model->purchaseOrder->system_sn = null;
                    if ($model->purchaseOrder->updateModel()) {
                        $model->resetLockingParams();
                        $model->updateModel();
                    }
                }

                return $this->goBack();
            } else {
                throw new ForbiddenHttpException;
            }

        }

        /**
         * This action is especially for endusers
         * It takes care to find out user system and display it on view
         *
         * @throws \yii\web\HttpException
         * @throws \yii\web\ForbiddenHttpException
         * @return \yii\web\Response
         */
        public function actionViewSystem()
        {
            //if (Yii::$app->user->can('viewSingleSystem')) {
            $system = System::getByLoginCode(Yii::$app->session->get('loginCode'));

                if (!is_null($system)) {
                    $this->redirect(['view', 'id' => $system->id]);
                } else {
                    return $this->render('view-enduser-system-not-found');
                }
            // } else {
            //     throw new ForbiddenHttpException;
            // }
        }

        /**
         * Tries to find system for end user
         *
         * @param $userId
         * @return System|null
         */
        private function findSystemForEndUser($userId)
        {
            $system = null;

            //find end user assigned to currently logged in user
            /**
             * @var $endUser EndUser
             */
            $endUser = EndUser::findOne(['user_id' => $userId]);

            //find po assigned to EU
            /**
             * @var $po PurchaseOrder
             */
            if ($endUser) {
                $po = $endUser->purchaseOrder;
                if ($po) {
                    $system = $po->system;
                }
            }

            return $system;
        }

    }
