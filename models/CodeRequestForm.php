<?php

    namespace app\models;

    use Yii;
    use yii\base\Model;

    /**
     * CodeRequestForm is the model behind the code requesting form.
     */
    class CodeRequestForm extends Model
    {
        public $system_sn;
        public $order_num;
        public $periods_qty;
        public $next_lock_date;

        /**
         * @return array the validation rules.
         */
        public function rules()
        {
            return [
                [['system_sn', 'order_num', 'periods_qty'], 'required'],
                [['periods_qty'], 'integer']
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

    }
