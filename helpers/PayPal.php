<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 8/15/14
     * Time: 1:33 PM
     */

    namespace app\helpers;


    use Exception;
    use yii\log\Logger;
    use Yii;

    class PayPal
    {
        protected $_errors = [];

        protected $_credentials = [
            'USER'      => 'endymed_ppd_merchant_api1.mailinator.com',
            'PWD'       => '1408096092',
            'SIGNATURE' => 'AibnSz1iFmP2skIIBInZeBeCq5PhA6DocR5VpBI8xh-8VNA28MNV8XES',
        ];

        protected $_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

        protected $_version = '98';

        public function request($method, $params = [])
        {
            $this->_errors = [];
            if (empty($method)) {
                $this->_errors[] = ['Payment method is not defined'];

                return false;
            }

            $requestParams = [
                    'METHOD'  => $method,
                    'VERSION' => $this->_version,
                ] + $this->_credentials;

            $request = http_build_query($requestParams + $params);

            $curlOptions = [
                CURLOPT_URL            => $this->_endpoint,
                CURLOPT_VERBOSE        => 1,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_CAINFO         => dirname(__FILE__) . '/cacert.pem',
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST           => 1,
                CURLOPT_POSTFIELDS     => $request
            ];

            $ch = curl_init();

            curl_setopt_array($ch, $curlOptions);

            $responce = curl_exec($ch);

            $logger = Yii::getLogger();

            if (curl_errno($ch)) {
                $this->_errors = curl_error($ch);
                curl_close($ch);
                $logger->log($this->_errors, Logger::LEVEL_ERROR, 'paypal');

                return false;
            } else {
                curl_close($ch);
                $responceArray = [];
                parse_str($responce, $responceArray);
                $logger->log($responceArray, Logger::LEVEL_INFO, 'paypal');

                return $responceArray;
            }
        }

        /**
         * Method gets payment details from user and sends to paypal
         * Paypal prepares to process a payment. When ready returns token
         *
         * @param $codeParams
         * @throws Exception
         * @return string $token
         */
        public function getToken($codeParams)
        {
            $callbackUrlParams = [
                'RETURNURL' => 'http://localhost:8890/payment/success?system_sn=' . $codeParams['system_sn'],
                'CANCELURL' => 'http://localhost:8890/payment/cancel?system_sn=' . $codeParams['system_sn'],
            ];

            $orderParams = [
                'PAYMENTREQUEST_0_AMT'          => $codeParams['cost'] * $codeParams['qty'], //total sum
                'PAYMENTREQUEST_0_CURRENCYCODE' => $codeParams['currency_code'],
                'PAYMENTREQUEST_0_CUSTOM'       => $codeParams['payment_from'], //in custom field we are storing payer identifying information (enduser/distributor)
                'REQCONFIRMSHIPPING'            => 0, //no need to confirm shipping as it is electronic good
                'NOSHIPPING'                    => 1, //no need in shipping
            ];

            $codeItem = [
                'L_PAYMENTREQUEST_0_NAME0' => \Yii::t('app', 'System Unlock Code'),
                'L_PAYMENTREQUEST_0_DESC0' => $codeParams['description'],
                'L_PAYMENTREQUEST_0_AMT0'  => $codeParams['cost'],
                'L_PAYMENTREQUEST_0_QTY0'  => $codeParams['qty'],
            ];

            $response = $this->request('SetExpressCheckout', $callbackUrlParams + $orderParams + $codeItem);

            $ack = $response['ACK'];

            if (is_array($response) && (($ack == 'Success') || ($ack == 'SUCCESSWITHWARNING'))) {
                if ($ack == 'SUCCESSWITHWARNING') {
                    Yii::$app->session->setFlash('notice', Yii::t('app', 'Operation successful, but with warning')); //TODO Add warning message here
                }
                $token = $response['TOKEN'];

                return $token;
            } else {
                throw new Exception('Error while requesting data (token) from PayPal');
            }
        }

        public function getPaymentDetails($token)
        {
            $params = [
                'TOKEN' => $token,
            ];
            $response = $this->request('GetExpressCheckoutDetails', $params);

            $ack = $response['ACK'];
            if (is_array($response) && (($ack == 'Success') || ($ack == 'SUCCESSWITHWARNING'))) {
                if ($ack == 'SUCCESSWITHWARNING') {
                    Yii::$app->session->setFlash('notice', Yii::t('app', 'Operation successful, but with warning')); //TODO Add warning message here
                }

                return $response;
            } else {
                throw new Exception('Error while requesting payment details from PayPal');
            }
        }

        public function confirmPayment($token, $payerId, $amount, $currencyCode)
        {
            $requestParams = [
                'TOKEN'                          => $token,
                'PAYERID'                        => $payerId,
                'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
                'PAYMENTREQUEST_0_CURRENCYCODE'  => $currencyCode,
                'PAYMENTREQUEST_0_AMT'           => $amount,
                'IPADDRESS'                      => $_SERVER['SERVER_NAME'],
            ];

            $response = $this->request('DoExpressCheckoutPayment', $requestParams);

            $ack = $response['ACK'];
            if (is_array($response) && (($ack == 'Success') || ($ack == 'SUCCESSWITHWARNING'))) {
                if ($ack == 'SUCCESSWITHWARNING') {
                    Yii::$app->session->setFlash('notice', Yii::t('app', 'Operation successful, but with warning')); //TODO Add warning message here
                }

                return $response;
            } else {
                throw new Exception('Failed to confirm payment');
            }

        }
    }