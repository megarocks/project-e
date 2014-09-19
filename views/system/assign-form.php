<?php

    use app\models\PurchaseOrder;
    use app\models\System;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model app\models\PoSystemModel */
    /* @var $form yii\widgets\ActiveForm */

    $this->title = Yii::t('app', 'Assign system to purchase order');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-create">
    <div class="system-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'system_id')->dropDownList(ArrayHelper::map(System::findAllFiltered(['status' => System::STATUS_UNASSIGNED]), 'id', 'sn')) ?>

        <?= $form->field($model, 'po_id')->dropDownList(ArrayHelper::map(PurchaseOrder::findAllFiltered(['system_sn' => null]), 'id', 'po_num')) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Assign'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>