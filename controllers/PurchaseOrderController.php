<?php

namespace app\controllers;

use app\models\PurchaseOrder;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
 */
class PurchaseOrderController extends Controller
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
     * Renders view with list of PurchaseOrders
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays a single PurchaseOrder model.
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
     * Updates an existing PurchaseOrder model.
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
     * Creates a new PurchaseOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurchaseOrder();

        $request = Yii::$app->request->post();

        if (!empty($request)) {
            $model->load($request);
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
     * Finds the PurchaseOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Return list of PurchaseOrders in json format
     */
    public function actionList($fields = [])
    {
        $orders = PurchaseOrder::find()->all();
        $result = [];
        //if fields are defined in request
        if (count($fields) > 0) {
            $specField = explode(",", $fields);
            /** @var $order PurchaseOrder */
            foreach ($orders as $order) {
                $o = null;
                foreach ($specField as $field) {
                    if ($field != "") {
                        $o[$field] = $order[$field];
                    }
                }
                if (isset($o)) {
                    $result[] = $o;
                }
            }
        } else { //return default fields set if not specified
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
                $o['distributor'] = $order->distributor->title;
                $o['country'] = $order->country->name;
                $result[] = $o;
            }
        }
        echo(Json::encode($result));
    }

}