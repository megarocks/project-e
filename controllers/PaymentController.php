<?php

    namespace app\controllers;

    use app\helpers\PayPal;
    use app\models\CodeRequestForm;
    use app\models\Payment;
    use app\models\PurchaseOrder;
    use app\models\User;
    use Yii;
    use app\models\System;
    use yii\db\ActiveRecord;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\helpers\Json;
    use yii\log\Logger;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;

    /**
     * PaymentController implements the actions related to payment operations.
     */
    class PaymentController extends PpdBaseController
    {

        public $modelName = 'app\models\Payment';

        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow'   => true,
                            'actions' => ['purchase-code', 'success', 'cancel', 'create', 'view', 'index', 'list', 'add-payment'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /***
         * Method called from system screen. It gets system by id from get param and renders form for adding payment
         * to this system
         *
         * @param $system_id
         * @throws \yii\web\ForbiddenHttpException
         * @return string|\yii\web\Response
         */
        public function actionCreate($system_id)
        {
            if (Yii::$app->user->can('createPayment')) {
                /**@var $user User */
                $user = Yii::$app->user->identity;

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
                        return $this->render('create-' . $user->role,
                            [
                                'model'  => $payment,
                                'system' => $system
                            ]);
                    }
                } else {
                    return $this->render('create-' . $user->role,
                        [
                            'model'  => $payment,
                            'system' => $system
                        ]);
                }

            } else {
                throw new ForbiddenHttpException;
            }

        }

        /**
         * Method called from index page. Renders form which gives capability to specify order/system to which
         * it needed to add a payment
         *
         * @throws \yii\web\ForbiddenHttpException
         * @return string|\yii\web\Response
         */
        public function actionAddPayment()
        {
            if (Yii::$app->user->can('createPayment')) {
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

            } else {
                throw new ForbiddenHttpException;
            }
        }

        /**
         *  Action gets data from code request form and initiates payment process
         *
         * @param $system_id
         * @throws \yii\web\ForbiddenHttpException
         * @internal param int|null $id this is system id
         * @return mixed
         */
        public function actionPurchaseCode($system_id)
        {
            if (Yii::$app->user->can('purchaseCode')) {
                /**@var $user User */
                $user = Yii::$app->user->identity;
                //Get post request body
                $request = Yii::$app->request->post();
                //prepare model for form
                $model = new CodeRequestForm;

                if (!empty($request)) {
                    $model->load($request);
                    $system = System::findBySN($model->system_sn);

                    $pp = new PayPal();
                    $token = $pp->getToken([
                        'system_sn'     => $system->sn, //sn of system
                        'cost'          => ($model->payment_from == Payment::FROM_DISTR) ? $system->purchaseOrder->dmp : $system->purchaseOrder->cmp, //cost of single period
                        'qty'           => $model->periods_qty, //qty of periods to pay
                        'description'   => Yii::t('app', 'Code for system #') . $system->sn, //code description
                        'currency_code' => $system->purchaseOrder->currency_code,
                        'payment_from'  => $model->payment_from,
                    ]);

                    if (!is_null($token)) {
                        $this->redirect('https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token));
                    }

                } else {
                    $system = $this->getSystem($system_id);
                    $model->system_sn = $system->sn;
                    $model->order_num = $system->purchaseOrder->po_num;
                    $model->periods_qty = 1;

                    return $this->render('code-purchase-form-' . $user->role, [
                            'model'  => $model,
                            'system' => $system
                        ]);
                }

            } else {
                throw new ForbiddenHttpException;
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

        public function actionCancel($system_sn)
        {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Payment was canceled'));
            Yii::getLogger()->log('Payment canceled by user', Logger::LEVEL_WARNING, 'paypal');

            $system = System::findBySN($system_sn);

            return $this->redirect(['system/view', 'id' => $system->id]);
        }

        /**
         * Method check if login code is set to the session
         * If not set will try to get system by id specified in request
         *
         * @param null|integer $id
         *
         * @throws \yii\web\NotFoundHttpException
         * @return System|null
         */
        private function getSystem($id = null)
        {
            $loginCode = Yii::$app->session->get('loginCode');
            if ($id) {
                $system = System::findOne($id);

                return $system;
            } elseif ($loginCode) {
                $system = System::getByLoginCode($loginCode);

                return $system;
            } else {
                throw new NotFoundHttpException;
            }
        }

    }