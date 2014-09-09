<?php

    namespace app\models;

    use yii\base\Model;
    use Yii;

    /**
     * This is the model class for PO to System assign form
     *
     * @property integer $po_num
     * @property integer $system_sn
     * @property System $system
     * @property PurchaseOrder $purchaseOrder
     */
    class PoSystemModel extends Model
    {

        public $po_id;
        public $system_id;

        public function  rules()
        {
            return [
                [['po_id', 'system_id'], 'required'],
                [['po_id', 'system_id'], 'integer']
            ];
        }

        public function attributeLabels()
        {
            return [
                'system_id' => Yii::t('app', 'System SN'),
                'po_id'     => Yii::t('app', 'Purchase Order #'),
            ];
        }

        public function assign()
        {
            if (!is_null($this->system) && !is_null($this->purchaseOrder)) {
                $system = $this->system;
                $po = $this->purchaseOrder;

                $po->system_sn = $system->sn;
                if ($po->updateModel()) {
                    $system->generateLockingParams();
                    $system->updateModel();

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function getSystem()
        {
            return System::findOne($this->system_id);
        }

        public function getPurchaseOrder()
        {
            return PurchaseOrder::findOne($this->po_id);
        }

    }