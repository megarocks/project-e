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
     * @property string $payment_from
     */
    class CodeRequestForm extends Model
    {
        public $system_sn;
        public $order_num;
        public $periods_qty;
        public $next_lock_date;
        public $payment_from;

        /**
         * @return array the validation rules.
         */
        public function rules()
        {
            return [
                [['system_sn', 'order_num', 'periods_qty', 'payment_from'], 'required'],
                [['periods_qty'], 'integer'],
                [['system_sn', 'order_num', 'periods_qty', 'require_payment', 'payment_from'], 'safe']
            ];
        }

        public function attributeLabels()
        {
            return [
                'system_sn'      => Yii::t('app', 'System SN'),
                'order_num'      => Yii::t('app', 'Purchase Order #'),
                'periods_qty'    => Yii::t('app', 'Periods to pay'),
                'next_lock_date' => Yii::t('app', 'Next Locking Date'),
                'payment_from'   => Yii::t('app', 'Payment From'),
            ];
        }
    }
