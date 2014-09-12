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
                            'actions' => ['index', 'view', 'create', 'update', 'list', 'dynamic-currency', 'delete'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
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