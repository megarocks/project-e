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
     * PaymentController implements the actions related to payment operations.
     */
    class PaymentController extends Controller
    {
        public function actionSuccess()
        {
            if (isset($_GET['token']) && !empty($_GET['token'])) {
                $paypal = new Paypal();
                $checkoutDetails = $paypal->request('GetExpressCheckoutDetails', array('TOKEN' => $_GET['token']));

                D($checkoutDetails);

                $requestParams = array(
                    'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
                    'PAYERID'                        => $_GET['PayerID'],
                    'TOKEN'                          => $_GET['token'],
                    'PAYMENTREQUEST_0_AMT'           => $checkoutDetails['AMT'],
                    'PAYMENTREQUEST_0_CURRENCYCODE'  => $checkoutDetails['CURRENCYCODE'],
                    'IPADDRESS'                      => urlencode($_SERVER['SERVER_NAME']),
                );

                $response = $paypal->request('DoExpressCheckoutPayment', $requestParams);

                D($response);

                if (is_array($response) && $response['ACK'] == 'Success') {
                    $transactionId = $response['PAYMENTINFO_0_TRANSACTIONID'];
                }
            }
        }
    }