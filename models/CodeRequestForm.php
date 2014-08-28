<?php

    namespace app\models;

    use Yii;
    use yii\base\Model;

    /**
     * CodeRequestForm is the model behind the code requesting form.
     *
     * @property integer $system_sn
     * @property integer $order_num
     * @property integer $periods_qty
     * @property string $next_lock_date
     * @property boolean $require_payment
     */
    class CodeRequestForm extends Model
    {
        public $system_sn;
        public $order_num;
        public $periods_qty;
        public $next_lock_date;
        public $require_payment = true;

        /**
         * @return array the validation rules.
         */
        public function rules()
        {
            return [
                [['system_sn', 'order_num', 'periods_qty'], 'required'],
                [['periods_qty'], 'integer'],
                [['system_sn', 'order_num', 'periods_qty', 'require_payment'], 'safe']
            ];
        }

        public function attributeLabels()
        {
            return [
                'system_sn'      => Yii::t('app', 'System SN'),
                'order_num'      => Yii::t('app', 'Purchase Order #'),
                'periods_qty'    => Yii::t('app', 'Periods to pay'),
                'next_lock_date' => Yii::t('app', 'Next Locking Date'),
            ];
        }

        /**
         * Method should check capability to generate code wo payment
         * If it's possible to generate code without should return false
         *
         * @param $system
         * @return boolean
         */

        public function checkIfPaymentNeeded($system)
        {
            return $this->require_payment == 'true';
        }
    }
