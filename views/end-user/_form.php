<?php

    use app\models\Country;
    use app\models\Distributor;
    use kartik\widgets\DepDrop;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $endUser app\models\EndUser */
    /* @var $relatedUser app\models\User */
    /* @var $form yii\widgets\ActiveForm */
    /* @var $countriesList array */

?>

<div class="end-users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
        $form->field($endUser, 'country_id')->dropDownList(
            ['' => Yii::t('app', 'Select Country...')] +
            $countriesList,
            ['id' => 'country_id']
        )
    ?>

    <?=
        $form->field($endUser, 'distributor_id')->widget(DepDrop::className(), [
                'options'       => ['id' => 'enduser-distributor_id'],
                'pluginOptions' => [
                    'depends'     => ['country_id'],
                    'placeholder' => Yii::t('app', 'Select distributor...'),
                    'url'         => \yii\helpers\Url::to(['/distributor/dynamic'])
                ],
                'data'          => (!$endUser->isNewRecord) ? [$endUser->distributor_id => $endUser->distributor->title] : ["" => Yii::t('app', 'Select country to view list of distributors')]
            ]
        );
    ?>

    <?= $form->field($relatedUser, 'first_name')->textInput(['maxlength' => 45])->label(Yii::t('app', 'Title/First Name')) ?>
    <?= $form->field($relatedUser, 'roleField')->hiddenInput()->label(false) ?>
    <?= $form->field($relatedUser, 'email')->textInput() ?>

    <?= $form->field($endUser, 'phone')->textInput() ?>
    <?= $form->field($endUser, 'contact_person')->textInput() ?>

    <?= $form->field($relatedUser, 'password')->hiddenInput()->label(false) ?>
    <?= $form->field($relatedUser, 'password_repeat')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($endUser->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $endUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
