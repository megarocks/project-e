<?php

    namespace app\controllers;

    use app\models\Country;
    use app\models\User;
    use Yii;
    use app\models\EndUser;
    use yii\db\ActiveRecord;
    use yii\filters\AccessControl;
    use yii\helpers\Json;
    use yii\web\Controller;
    use yii\web\ForbiddenHttpException;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * EndusersController implements the CRUD actions for EndUsers model.
     */
    class EndUserController extends PpdBaseController
    {
        public $modelName = 'app\models\EndUser';

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
                            'actions' => ['index', 'view', 'create', 'update', 'list', 'dynamic', 'delete'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Returns json string with endUsers filtered by country
         * used for dependent dropdowns
         */
        public function actionDynamic()
        {
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                if ($parents != null) {
                    $countryId = $parents[0];
                    $country = Country::findOne(['id_countries' => $countryId]);
                    $endUsers = $country->endUsers;
                    $out = [];
                    $res = [];
                    foreach ($endUsers as $eu) {
                        $res['id'] = $eu->id;
                        $res['name'] = $eu->title;
                        $out[] = $res;
                    }
                    echo Json::encode(['output' => $out, 'selected' => '']);

                    return;
                }
            }
            echo Json::encode(['output' => '', 'selected' => '']);
        }

    }
