<?php

    namespace app\controllers;

    use app\helpers\PayPal;
    use app\models\CodeRequestForm;
    use app\models\Payment;
    use Yii;
    use app\models\System;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * PaymentController implements the actions related to payment operations.
     */
    class PaymentController extends Controller
    {
        /**
         *  Action gets data from code request form and initiates payment process
         *
         * @throws \yii\web\NotFoundHttpException
         * @return mixed
         */
        public function actionRequestCode()
        {
            $request = Yii::$app->request->post();
            $model = new CodeRequestForm;

            if (empty($request)) {
                //get system code from session
                $loginCode = Yii::$app->session->get('loginCode');
                if (!is_null($loginCode)) {

                    //get system by the code
                    $system = System::getByLoginCode($loginCode);
                    $po = $system->purchaseOrder;

                    //initialize code request form
                    $model->system_sn = $system->sn;
                    $model->order_num = $po->po_num;
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
                if ($model->checkIfPaymentNeeded()) {
                    $pp = new PayPal();

                    //send request to pp with initial payment data.
                    $token = $pp->getToken([
                        'system_sn'   => $system->sn,
                        'cost'        => $system->purchaseOrder->cmp,
                        'qty'         => $model->periods_qty,
                        'description' => Yii::t('app', 'Code for system #') . $system->sn,
                    ], 'USD'); //TODO Currency is hardcoded
                    //if pp is ready to process payment it returns token
                    if (!is_null($token)) {
                        // navigate user to pp to authorize it
                        $this->redirect('https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token));
                    }
                } else {
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
                    $payment = new Payment();
                    $payment->loadDataFromPayPal(
                        $system->purchaseOrder->po_num,
                        $paymentDetails,
                        $confirmPayment
                    );
                    $payment->save();

                    //update system locking params accordingly to payment
                    $system->purchaseOrder->processPayment($payment);

                    //navigate to view to notice user about results
                    $this->redirect('system/view-by-code');

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
            $this->redirect('system/view-by-code');
        }
    }