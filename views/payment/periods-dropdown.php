<?php
    use app\models\Payment;
    use app\models\System;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;

    /**
     * @var $system System
     * @var string $for
     */

    $periods = $system->getLockingDates($for);

    echo Html::activeDropDownList(new Payment(), 'periods', ArrayHelper::map($periods, 'periods', 'periods'), ['id' => 'payment-periods', 'class' => 'form-control', 'options' => $periods]);

?>