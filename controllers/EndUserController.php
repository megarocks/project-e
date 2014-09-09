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
                            'actions' => ['index', 'view', 'create', 'update', 'list', 'dynamic'],
                            'roles'   => ['@'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Returns json array with list of endUsers
         *
         * @param null $fields
         * @return string
         */
        public function actionList($fields = null)
        {
            if ($fields) {
                echo parent::actionList($fields);

                return;
            } else {
                $className = $this->modelName;
                $endUsers = $className::findAllFiltered();
                $result = [];

                /**@var $endUser EndUser */
                foreach ($endUsers as $endUser) {
                    $eu['id'] = $endUser->id;
                    $eu['title'] = $endUser->title;
                    $eu['email'] = $endUser->email;
                    $eu['country'] = isset($endUser->country) ? $endUser->country->name : null;
                    $eu['created_at'] = date('M d, Y h:i A', strtotime($endUser->created_at));
                    $result[] = $eu;
                }
            }
            echo(Json::encode($result));
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
