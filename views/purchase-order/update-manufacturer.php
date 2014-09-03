<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model app\models\PurchaseOrder */

    $this->title = Yii::t('app', 'Edit system order');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Orders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->po_num, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Edit');
?>
<div class="systems-update">
    <div class="systems-orders-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'po_num')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'system_sn')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Assign'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>