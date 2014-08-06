<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class PurchaseOrderController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}