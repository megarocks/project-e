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
        public $po_num;
        public $system_sn;

        public function  rules()
        {
            return [
                [['po_num', 'system_sn'], 'required'],
                [['po_num', 'system_sn'], 'integer']
            ];
        }

        public function attributeLabels()
        {
            return [
                'po_num'    => Yii::t('app', 'PO# (Purchase Order Number)'),
                'system_sn' => Yii::t('app', 'System SN'),
            ];
        }

        public function assign()
        {
            if ($this->system && $this->purchaseOrder) {
                $po = $this->purchaseOrder;
                $po->system_sn = $this->system_sn;

                return $po->save();
            } else {
                return false;
            }
        }

        public function getSystem()
        {
            return System::findBySN($this->system_sn);
        }

        public function getPurchaseOrder()
        {
            return PurchaseOrder::findOne(['po_num' => $this->po_num]);
        }

    }