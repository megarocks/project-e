<?php
    namespace app\widgets;

    use app\models\Payment;
    use app\models\System;
    use yii\bootstrap\Widget;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;

    class PeriodsDropDown extends Widget
    {
        /**
         * @var $system System
         */
        public $system;
        public $for;

        public function run()
        {

            $periods = $this->system->getLockingDates($this->for);

            if (count($periods) > 0) {
                return Html::activeDropDownList(new Payment(), 'periods', ArrayHelper::map($periods, 'periods', 'periods'), ['id' => 'payment-periods', 'class' => 'form-control', 'options' => $periods]);
            } else {
                return Html::activeDropDownList(new Payment(), 'periods', ['0' => \Yii::t('app', 'All periods are already payed')], ['id' => 'payment-periods', 'class' => 'form-control', 'enabled' => 'false']);
            }
        }

    }
