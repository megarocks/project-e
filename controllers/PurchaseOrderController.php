<?php

    namespace app\controllers;

    use app\models\Country;
    use app\models\PurchaseOrder;
    use app\models\System;
    use app\models\User;
    use Yii;
    use yii\db\ActiveRecord;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\helpers\Json;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;
    use yii\web\UnauthorizedHttpException;

    /**
     * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
     */
    class PurchaseOrderController extends PpdBaseController
    {

        public $modelName = 'app\models\PurchaseOrder';

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
                            'actions' => ['index', 'view', 'create', 'update', 'list', 'dynamic-currency'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Return list of PurchaseOrders in json format
         *
         * @param $fields string|null
         * @return string
         */
        public function actionList($fields = null)
        {
            //if fields are defined in request
            if ($fields) {
                echo parent::actionList($fields);

                return;
            } else {

                $orders = $this->getModelsListForCurrentUser();
                $result = [];

                /** @var $order PurchaseOrder */
                foreach ($orders as $order) {
                    $o['id'] = $order->id;
                    $o['po_num'] = $order->po_num;
                    $o['created_at'] = date('M d, Y h:i A', strtotime($order->created_at));
                    $o['cpup'] = $order->cpup;
                    $o['dpup'] = $order->dpup;
                    $o['dsp'] = $order->dsp;
                    $o['csp'] = $order->csp;
                    $o['nop'] = $order->nop;
                    $o['distributor'] = isset($order->distributor->title) ? $order->distributor->title : null;
                    $o['country'] = isset($order->country->name) ? $order->country->name : null;
                    $result[] = $o;
                }
            }
            echo(Json::encode($result));
        }

        /**
         * Returns json string with currencies filtered by country
         * used for dependent dropdowns
         */
        public function actionDynamicCurrency()
        {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                if ($parents != null) {
                    $countryId = $parents[0];
                    $country = Country::findOne(['id_countries' => $countryId]);

                    $out = [];

                    $countryCurrency['id'] = $country->currency_code;
                    $countryCurrency['name'] = $country->currency_code;
                    $out[] = $countryCurrency;
                    //if country currency is not USD - add it just in case
                    if ($countryCurrency['id'] != 'USD') {
                        $out[] = [
                            'id'   => 'USD',
                            'name' => 'USD',
                        ];
                    }
                    echo Json::encode(['output' => $out, 'selected' => 'USD']);

                    return;
                }
            }
            echo Json::encode(['output' => '', 'selected' => 'USD']);
        }

    }