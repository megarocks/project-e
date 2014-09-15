<?php

use app\models\Country;
use app\models\Distributor;
    use app\models\EndUser;
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

    <?= $form->field($model, 'country_id')->dropDownList([null => Yii::t('app', 'Select Country...')] + ArrayHelper::map(Country::find()->all(), 'id_countries', 'name'), ['id' => 'purchaseorder-country_id']) ?>
    <?= $form->field($model, 'po_num')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <?=
        $form->field($model, 'currency_code')->widget(DepDrop::className(), [
            'options'       => ['id' => 'purchaseorder-currency_code'],
            'pluginOptions' => [
                'depends' => ['purchaseorder-country_id'],
                'placeholder' => Yii::t('app', 'Select currency...'),
                'url'         => \yii\helpers\Url::to(['dynamic-currency'])
            ],
            'data' => ['' => Yii::t('app', 'Select Currency...')] + ArrayHelper::map(Country::find()->all(), 'currency_code', 'currency_code'),

        ]);
    ?>
    <?= $form->field($model, 'cpup')->textInput() ?>
    <?= $form->field($model, 'dpup')->textInput() ?>
    <?= $form->field($model, 'dsp')->textInput() ?>
    <?= $form->field($model, 'csp')->textInput() ?>
    <?= $form->field($model, 'nop')->textInput() ?>
    <?=
    $form->field($model, 'distributor_id')->widget(DepDrop::className(), [
        'options'       => ['id' => 'purchaseorder-distributor_id'],
        'pluginOptions' => [
            'depends' => ['purchaseorder-country_id'],
            'placeholder' => Yii::t('app', 'Select distributor...'),
            'url' => \yii\helpers\Url::to(['/distributor/dynamic'])
        ],
        'data' => ['' => Yii::t('app', 'Select Distributor...')] + ArrayHelper::map(Distributor::find()->all(), 'id', 'title'),
    ]);
    ?>

    <?=
        $form->field($model, 'end_user_id')->widget(DepDrop::className(), [
            'options'       => ['id' => 'purchaseorder-end_user_id'],
            'pluginOptions' => [
                'depends' => ['purchaseorder-country_id'],
                'placeholder' => Yii::t('app', 'Select end-user...'),
                'url'         => \yii\helpers\Url::to(['/end-user/dynamic'])
            ],
            'data' => ['' => Yii::t('app', 'Select End-User...')] + ArrayHelper::map(EndUser::find()->all(), 'id', 'title'),
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>