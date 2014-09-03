<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;

?>


<div class="widget-main">
    <h4 class="header red lighter bigger">
        <i class="ace-icon fa fa-key"></i>
        <?= Yii::t('app', 'Retrieve Password') ?>
    </h4>

    <div class="space-6"></div>

    <p><?= Yii::t('app', 'Enter your email to receive instructions') ?></p>

    <?php $form = ActiveForm::begin(['action' => '/site/login?visibleForm=forgot']) ?>
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
                    <i class="ace-icon fa fa-envelope"></i>
                </span>
            </label>

            <div class="clearfix">

                <?=
                    Html::submitButton(
                        '<i class="ace-icon fa fa-lightbulb-o"></i>' .
                        '<span class="bigger-110">' . Yii::t('app', 'Send Instructions') . '</span>',
                        ['class' => 'width-55 pull-right btn btn-sm btn-danger', 'name' => 'remind-button']) ?>
            </div>

        </fieldset>
    </form>
    <?php ActiveForm::end(); ?>

</div>

<div class="toolbar center">
    <?=
        Html::a(Yii::t('app', 'Back to login'), '#', [
            'class'       => 'back-to-login-link',
            'data-target' => '#credentials-box'
        ]) ?>
</div>

