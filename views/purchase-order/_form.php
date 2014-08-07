<?php

use app\models\Country;
use app\models\Distributor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="po-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'po_num')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'cpup')->textInput() ?>
    <?= $form->field($model, 'epup')->textInput() ?>
    <?= $form->field($model, 'esp')->textInput() ?>
    <?= $form->field($model, 'csp')->textInput() ?>
    <?= $form->field($model, 'nop')->textInput() ?>
    <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(Country::find()->all(), 'id_countries', 'name'), ['id' => 'country-id']) ?>
    <?=
    $form->field($model, 'distributor_id')->widget(DepDrop::className(), [
        'options' => ['id' => 'distributor-id'],
        'pluginOptions' => [
            'depends' => ['country-id'],
            'placeholder' => Yii::t('app', 'Select distributor...'),
            'url' => \yii\helpers\Url::to(['/distributor/dynamic'])
        ],
        'data' => ArrayHelper::map(Distributor::find()->all(), 'id', 'title'),
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>