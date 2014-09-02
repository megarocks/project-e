<?php

    namespace app\controllers;

    use app\helpers\PayPal;
    use app\models\CodeRequestForm;
    use app\models\Payment;
    use app\models\PurchaseOrder;
    use app\models\User;
    use Yii;
    use app\models\System;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\helpers\Json;
    use yii\log\Logger;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;

    /**
     * PaymentController implements the actions related to payment operations.
     */
    class PaymentController extends Controller
    {
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow'   => true,
                            'actions' => ['request-code', 'success', 'cancel', 'create', 'view', 'index', 'list', 'add-payment'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        protected function findModel($id)
        {
            if (($model = Payment::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        public function actionIndex()
        {
            /**@var User $user */
            $user = Yii::$app->user->identity;

            return $this->render('index-' . $user->role);
        }

        public function actionView($id)
        {
            /**@var $user User */
            $user = Yii::$app->user->identity;
            /**@var $payment Payment */
            $payment = $this->findModel($id);

            return $this->render('view-' . $user->role, ['model' => $payment]);
        }

        public function actionCreate($system_id)
        {
            $request = Yii::$app->request->post();

            $system = $this->getSystem($system_id);

            $payment = new Payment(['scenario' => Payment::METHOD_MANUAL]);

            if (!empty($request)) {
                $payment->load($request);
                if ($payment->save()) {
                    //update system locking params accordingly to payment
                    $system->purchaseOrder->processPayment($payment);

                    //navigate to view with payment details
                    return $this->redirect('payment/' . $payment->id);
                } else {
                    return $this->render('create',
                        [
                            'model'  => $payment,
                            'system' => $system
                        ]);
                }
            } else {
                return $this->render('create',
                    [
                        'model'  => $payment,
                        'system' => $system
                    ]);
            }
        }

        public function actionAddPayment()
        {
            /**@var $user User */
            $user = Yii::$app->user->identity;

            /**@var $payment Payment */
            $payment = new Payment(['scenario' => Payment::METHOD_MANUAL]);

            $request = Yii::$app->request->post();
            if (!empty($request)) {
                $payment->load($request);
                if ($payment->save()) {
                    /**@var $order PurchaseOrder */
                    $order = $payment->purchaseOrder;
                    $order->processPayment($payment);

                    return $this->redirect('payment/' . $payment->id);
                } else {
                    return $this->render('add-payment-' . $user->role, ['model' => $payment]);
                }
            } else {
                return $this->render('add-payment-' . $user->role, ['model' => $payment]);
            }
        }

        public function actionDelete()
        {
            $request = Yii::$app->request->post();

            if (!empty($request)) {
                $payment = $this->findModel($request['payment_id']);
                if ($payment->purchaseOrder->revokePayment($payment)) {
                    $payment->delete();
                }
            }
        }

        /**
         *  Action gets data from code request form and initiates payment process
         *
         * @param null|integer $id
         * @throws \yii\web\NotFoundHttpException
         * @return mixed
         */
        public function actionRequestCode($id = null)
        {
            //Get post request body
            $request = Yii::$app->request->post();
            //prepare model for form
            $model = new CodeRequestForm;

            //if nothing is posted
            if (empty($request)) {
                //get system
                $system = $this->getSystem($id);

                //if system has been found
                if ($system) {

                    //initialize code request form
                    $model->system_sn = $system->sn;
                    $model->order_num = $system->purchaseOrder->po_num;
                    $model->periods_qty = 1;


                    return $this->render('code-request-form', [
                        'model'  => $model,
                        'system' => $system
                    ]);

                } else {
                    throw new NotFoundHttpException;
                }
            } else {
                $model->load($request);

                //find system by serial number from code request form
                $system = System::findBySN($model->system_sn);

                //if payment is needed for generation of code
                if ($model->checkIfPaymentNeeded($system)) {
                    $pp = new PayPal();

                    //send request to pp with initial payment data.
                    $token = $pp->getToken([
                        'system_sn'   => $system->sn, //sn of system
                        'cost'        => $system->purchaseOrder->cmp, //cost of single period
                        'qty'         => $model->periods_qty, //qty of periods to pay
                        'description' => Yii::t('app', 'Code for system #') . $system->sn, //code description
                    ], $system->purchaseOrder->currency_code);
                    //if pp is ready to process payment it returns token
                    if (!is_null($token)) {
                        // navigate user to pp to authorize it
                        $this->redirect('https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token));
                    }
                } else {
                    echo "Generating code...";
                    //if payment is not needed we can trigger system locking params update somewhere here
                }
            }
        }

        /**
         * Action handles pp callback in case of success. Saves payment details and initiates system locking params update
         *
         * @param $system_sn
         * @throws \yii\web\NotFoundHttpException
         * @throws \yii\web\BadRequestHttpException
         * @return mixed
         */
        public function actionSuccess($system_sn)
        {
            //handle successful payment callback
            $get = Yii::$app->request->get();
            $system = System::findBySN($system_sn);
            if (!is_null($system)) {
                $pp = new PayPal();
                if (isset($get['token'])) {
                    //get payment details from paypal
                    $paymentDetails = $pp->getPaymentDetails($get['token']);

                    //confirm payment
                    $confirmPayment = $pp->confirmPayment(
                        $get['token'],
                        $paymentDetails['PAYERID'],
                        $paymentDetails['AMT'],
                        $paymentDetails['CURRENCYCODE']
                    );

                    //save payment to DB after confirmation
                    $payment = new Payment(['scenario' => Payment::METHOD_PAYPAL]);
                    $payment->loadDataFromPayPal(
                        $system->purchaseOrder->po_num,
                        $paymentDetails,
                        $confirmPayment
                    );

                    if ($payment->save()) {
                        //update system locking params accordingly to payment
                        $system->purchaseOrder->processPayment($payment);

                        //navigate to view with payment details
                        return $this->redirect('payment/' . $payment->id);
                    }
                } else {
                    throw new BadRequestHttpException('Transaction token is missing');
                }
            } else {
                throw new NotFoundHttpException('System with SN:' . $system_sn . ' not found');
            }
        }

        public function actionCancel()
        {
            Yii::$app->session->setFlash('notice', Yii::t('app', 'Payment was canceled'));
            Yii::getLogger()->log('Payment canceled by user', Logger::LEVEL_WARNING, 'paypal');
            $this->redirect('system/view-by-code');
        }

        /**
         * Method check if login code is set to the session
         * If not set will try to get system by id specified in request
         *
         * @param null|integer $id
         *
         * @return System|null
         */
        private function getSystem($id = null)
        {
            $system = null;
            if ($id) {
                $system = System::findOne($id);
            } else {
                $loginCode = Yii::$app->session->get('loginCode');
                if ($loginCode) {
                    $system = System::getByLoginCode($loginCode);
                }
            }

            return $system;
        }

        /**
         * Returns json array with list of payments
         *
         * @param null $fields
         * @return string
         */
        public function actionList($fields = null)
        {
            $payments = Payment::find()->all();
            $result = [];

            if ($fields) {
                $specifiedFields = explode(",", $fields);
                /**@var $payment Payment */
                foreach ($payments as $payment) {
                    $p = null;
                    foreach ($specifiedFields as $field) {
                        if ($field != '') {
                            $p[$field] = $payment[$field];
                        }
                    }
                    if (!is_null($p)) {
                        $result[] = $p;
                    }
                }
            } else {
                /**@var $payment Payment */
                foreach ($payments as $payment) {
                    $eu['id'] = $payment->id;
                    $eu['po_num'] = $payment->po_num;
                    $eu['amount'] = $payment->amount;
                    $eu['periods'] = $payment->periods;
                    $eu['currency'] = $payment->currency_code;
                    $eu['payer_email'] = $payment->payer_email;
                    $eu['method'] = $payment->method;
                    $eu['created_at'] = date('M d, Y h:i A', strtotime($payment->created_at));
                    $result[] = $eu;
                }
            }
            echo(Json::encode($result));
        }

    }