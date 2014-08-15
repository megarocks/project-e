<?php

    namespace app\controllers;

    use app\helpers\PayPal;
    use app\models\CodeRequestForm;
    use app\models\User;
    use Yii;
    use app\models\System;
    use yii\helpers\Json;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * SystemsController implements the CRUD actions for Systems model.
     */
    class SystemController extends Controller
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
            ];
        }

        /**
         * Lists all Systems models.
         * @throws \yii\web\UnauthorizedHttpException
         * @return mixed
         */
        public function actionIndex()
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            if ($user->hasRole(User::ROLE_DISTR)) {
                return $this->render('index-' . User::ROLE_DISTR);
            } else {
                throw new UnauthorizedHttpException;
            }
        }

        /**
         * Displays a single Systems model.
         * @param integer $id
         * @throws \yii\web\UnauthorizedHttpException
         * @return mixed
         */
        public function actionView($id)
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            if ($user->hasRole(User::ROLE_DISTR)) {
                return $this->render('view-' . User::ROLE_DISTR, [
                        'model' => $this->findModel($id),
                        'po'    => $this->findModel($id)->purchaseOrder,
                    ]);
            } else {
                throw new UnauthorizedHttpException;
            }

        }

        /**
         * Finds the Systems model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return System the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = System::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        public function actionList()
        {

            $systems = System::find()->all();
            $result = [];

            /**@var System $system */
            foreach ($systems as $system) {
                $s['id'] = $system->id;
                $s['sn'] = $system->sn;
                $s['status'] = $system->status;
                $s['po_num'] = isset($system->purchaseOrder) ? $system->purchaseOrder->po_num : null;
                $s['next_lock_date'] = $system->next_lock_date;
                $s['current_code'] = $system->current_code;
                $s['login_code'] = $system->login_code;
                $s['npl'] = isset($system->purchaseOrder) ? $system->purchaseOrder->npl : null;
                $s['ctpl'] = isset($system->purchaseOrder) ? $system->purchaseOrder->ctpl : null;
                $result[] = $s;
            }
            echo(Json::encode($result));
        }

        public function actionRequestCode()
        {
            $request = Yii::$app->request->post();

            $requestParams = array(
                'RETURNURL' => 'http://localhost:8890/payment/success',
                'CANCELURL' => 'http://localhost:8890/payment/cancel'
            );

            $orderParams = array(
                'PAYMENTREQUEST_0_AMT'          => '500',
                'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
                'PAYMENTREQUEST_0_ITEMAMT'      => '500'
            );

            $item = array(
                'L_PAYMENTREQUEST_0_NAME0' => 'System Unlock Code',
                'L_PAYMENTREQUEST_0_DESC0' => 'Unlock code for system #100500',
                'L_PAYMENTREQUEST_0_AMT0'  => '500',
                'L_PAYMENTREQUEST_0_QTY0'  => '1'
            );

            $paypal = new PayPal();

            $responce = $paypal->request('SetExpressCheckout', $requestParams + $orderParams + $item);

            if (is_array($responce) && $responce['ACK'] == 'Success') {
                $token = $responce['TOKEN'];
                header('Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token));
            }
        }

        public function actionViewByCode()
        {
            $loginCode = Yii::$app->session->get('loginCode');
            if (!is_null($loginCode)) {
                $model = System::getByLoginCode($loginCode);

                return $this->render('view-enduser', [
                    'model' => $model,
                    'po'    => $model->purchaseOrder,
                ]);
            } else {
                throw new NotFoundHttpException;
            }
        }
    }
