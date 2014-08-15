<?php
    /**
     * Created by PhpStorm.
     * User: rocks
     * Date: 8/15/14
     * Time: 1:33 PM
     */

    namespace app\helpers;


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

            if (curl_errno($ch)) {
                $this->_errors = curl_error($ch);
                curl_close($ch);

                return false;
            } else {
                curl_close($ch);
                $responceArray = [];
                parse_str($responce, $responceArray);

                return $responceArray;
            }
        }
    }