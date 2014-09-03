<?php

    use app\models\System;
    use kartik\widgets\DatePicker;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model app\models\System */
    /* @var $form yii\widgets\ActiveForm */

    $this->title = Yii::t('app', 'Register new system');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systems'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-create">
    <div class="system-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'sn')->textInput(['maxlength' => 10]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Register') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>