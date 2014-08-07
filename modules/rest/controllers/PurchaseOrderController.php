<?php
namespace app\modules\rest\controllers;

use yii\rest\ActiveController;

class PurchaseOrderController extends ActiveController
{
    public $modelClass = 'app\models\PurchaseOrder';
}