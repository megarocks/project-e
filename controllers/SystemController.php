<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\System;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;

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
     * @throws \yii\web\UnauthorizedHttpException
     * @return mixed
     */
    public function actionIndex()
    {
        /**@var User $user */
        $user = Yii::$app->user->identity;

        if ($user->hasRole(User::ROLE_DISTR)) {
            return $this->render('index-' . User::ROLE_DISTR);
        } elseif ($user->hasRole(User::ROLE_END_USER)) {
            return $this->render('index-' . User::ROLE_END_USER);
        } else {
            throw new UnauthorizedHttpException;
        }

    }

    /**
     * Displays a single Systems model.
     * @param integer $id
     * @throws \yii\web\UnauthorizedHttpException
     * @return mixed
     */
    public function actionView($id)
    {
        /**@var User $user */
        $user = Yii::$app->user->identity;

        if ($user->hasRole(User::ROLE_DISTR)) {
            return $this->render('view-' . User::ROLE_DISTR, [
                    'model' => $this->findModel($id),
                    'po' => $this->findModel($id)->purchaseOrder,
                ]);
        } elseif ($user->hasRole(User::ROLE_END_USER)) {
            return $this->render('view-' . User::ROLE_END_USER, [
                    'model' => $this->findModel($id),
                    'po' => $this->findModel($id)->purchaseOrder,
                ]);
        } else {
            throw new UnauthorizedHttpException;
        };

    }

    /**
     * Finds the Systems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return System the loaded model
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

    public function actionList()
    {

        $systems = System::find()->all();
        $result = [];

        /**@var System $system */
        foreach ($systems as $system) {
            $s['id'] = $system->id;
            $s['sn'] = $system->sn;
            $s['status'] = $system->status;
            $s['po_num'] = isset($system->purchaseOrder) ? $system->purchaseOrder->po_num : null;
            $s['next_lock_date'] = $system->next_lock_date;
            $s['current_code'] = $system->current_code;
            $s['npl'] = isset($system->purchaseOrder) ? $system->purchaseOrder->npl : null;
            $s['ctpl'] = isset($system->purchaseOrder) ? $system->purchaseOrder->ctpl : null;
            $result[] = $s;
        }
        echo(Json::encode($result));
    }

}
