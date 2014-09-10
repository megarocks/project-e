<?php

    namespace app\controllers;

    use app\models\Country;
    use app\models\DistributorCountry;
    use app\models\User;
    use Yii;
    use app\models\Distributor;
    use yii\db\ActiveRecord;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\helpers\Json;

    /**
     * DistributorsController implements the CRUD actions for Distributors model.
     */
    class DistributorController extends PpdBaseController
    {

        public $modelName = 'app\models\Distributor';

        /**
         * @return array
         */
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
                            'actions' => ['index', 'view', 'create', 'update', 'list', 'dynamic'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Get country specified in "dependent dropdown"
         * Returns json encoded list of distributors assigned to the specified country
         *
         * @param depdrop_parents
         * @return string
         */
        public function actionDynamic()
        {
            //check if value in parent dropdown has been specified
            if (isset($_POST['depdrop_parents'])) {
                //get list of parent dropdowns
                $parents = $_POST['depdrop_parents'];
                if ($parents != null) {
                    //get first value of array with parameters from parent dropdown
                    $countryId = $parents[0];
                    //find a country by the id
                    $country = Country::findOne(['id_countries' => $countryId]);
                    //get list of distributors assigned to found country
                    $distributors = $country->distributors;
                    $out = [];
                    $res = [];
                    //prepare array with found distributors
                    foreach ($distributors as $d) {
                        $res['id'] = $d->id;
                        $res['name'] = $d->title;
                        $out[] = $res;
                    }
                    //return json array with list of distributors
                    echo Json::encode(['output' => $out, 'selected' => '']);
                }
            } else {
                //if country is not specified return empty list
                echo Json::encode(['output' => '', 'selected' => '']);
            }

        }

    }
