<?php

namespace app\controllers;

use app\models\PurchaseOrder;
use Yii;
use app\models\System;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SystemsController implements the CRUD actions for Systems model.
 */
class SystemController extends Controller
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
     * Lists all Systems models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays a single Systems model.
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
     * Creates a new Systems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Systems();

        $request = Yii::$app->request->post();

        if (!empty($request)) {
            $model->load($request);
            $model->next_lock_date = date('c', strtotime($request['Systems']['next_lock_date']));
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Systems model.
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
            $model->next_lock_date = date('c', strtotime($request['Systems']['next_lock_date']));
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //TODO Handle error while saving
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Systems model.
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
     * Finds the Systems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Systems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = System::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionListOrders()
    {
        return $this->render('list-orders');
    }

    public function actionViewOrder($id)
    {
        return $this->render('view-system-order', [
            'model' => PurchaseOrder::findOne($id),
        ]);
    }

    public function actionUpdateOrder($id)
    {
        $model = PurchaseOrder::findOne($id);

        $request = Yii::$app->request->post();

        if (!empty($request)) {
            $model->load($request);

            if (($model->system_sn) && ($model->validate())) {
                $system = System::findOne(['sn' => $model->system_sn]);
                if (is_null($system)) {
                    $system = new System();
                }
                $system->sn = $model->system_sn;
                $system->save();
            }
            if ($model->save()) {
                return $this->redirect(['view-order', 'id' => $model->id]);
            } else {
                return $this->render('update-order', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update-order', [
                'model' => $model,
            ]);
        }
    }
}
