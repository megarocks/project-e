<?php

namespace app\controllers;

use app\models\Country;
use app\models\DistributorCountry;
use Yii;
use app\models\Distributor;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * DistributorsController implements the CRUD actions for Distributors model.
 */
class DistributorController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Distributors models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays a single Distributors model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Distributors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Distributor();

        $request = Yii::$app->request->post();

        if (!empty($request)) {
            $model->load($request);
            if ($model->save()) {
                $model->saveCountry();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Distributors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request->post();

        if (!empty($request)) {
            $model->load($request);
            if ($model->save()) {
                $model->saveCountry();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //TODO Handle error while saving
            }
        } else {
            $model->countryId = $model->getCountryId();
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Distributors model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Distributors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Distributor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Distributor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionList()
    {
        $distributors = Distributor::find()->all();
        $result = [];
        foreach ($distributors as $distributor) {
            $d['id'] = $distributor->id;
            $d['title'] = $distributor->title;
            $d['email'] = $distributor->email;
            $d['country'] = $distributor->countryName;
            $result[] = $d;
        }

        echo(Json::encode($result));
    }

    public function actionDynamic()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $countryId = $parents[0];
                $country = Country::findOne(['id_countries' => $countryId]);
                $distributors = $country->distributors;
                $out = [];
                $res = [];
                foreach ($distributors as $d) {
                    $res['id'] = $d->id;
                    $res['name'] = $d->title;
                    $out[] = $res;
                }
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
}
