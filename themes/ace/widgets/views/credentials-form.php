<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;

?>


<div class="widget-main">
    <h4 class="header blue lighter bigger">
        <i class="ace-icon fa fa-coffee green"></i>
        <?= Yii::t('app', 'Please Enter Your Information') ?>
    </h4>

    <div class="space-6"></div>
    <?php $form = ActiveForm::begin(['action' => '/site/login?initForm=credentials']) ?>
    <form>
        <fieldset>

            <label class="block clearfix">
                <span class="block input-icon input-icon-right">
                    <?=
                        $form->field($model, 'email')->textInput(
                            [
                                'placeholder' => Yii::t('app', 'Email'),
                                'class'       => 'form-control'
                            ]
                        )->label(false)
                    ?>
                    <i class="ace-icon fa fa-user"></i>
                </span>
            </label>

            <label class="block clearfix">
                <span class="block input-icon input-icon-right">
                    <?=
                        $form->field($model, 'password')->passwordInput(
                            [
                                'placeholder' => Yii::t('app', 'Password'),
                                'class'       => 'form-control'
                            ]
                        )->label(false)
                    ?>
                    <i class="ace-icon fa fa-lock"></i>
                </span>
            </label>

            <div class="space"></div>

            <div class="clearfix">

                <label class="inline">
                    <?= Html::activeCheckbox($model, 'rememberMe', ['class' => 'ace']) ?>
                    <span class="lbl"> <?= Yii::t('app', 'Remember Me') ?></span>
                </label>

                <?=
                    Html::submitButton(
                        '<i class="ace-icon fa fa-key"></i>' .
                        '<span class="bigger-110">' . Yii::t('app', 'Login') . '</span>',
                        ['class' => 'width-35 pull-right btn btn-sm btn-primary', 'name' => 'login-button']) ?>
            </div>

            <div class="space-4"></div>

        </fieldset>
    </form>
    <?php ActiveForm::end(); ?>

    <div class="social-or-login center">
        <span class="bigger-110"><?= Yii::t('app', 'Or Login Using') ?> </span>
    </div>

    <div class="space-6"></div>

    <div class="social-login center">
        <?= Html::a(Yii::t('app', 'System Code'), '#') ?>
    </div>
</div>

