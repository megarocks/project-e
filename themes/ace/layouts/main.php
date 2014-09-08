<?php
    use app\helpers\FlashAlert;
    use app\models\User;
    use app\themes\ace\assets\AceAsset;
    use yii\bootstrap\Nav;
    use yii\helpers\Html;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use app\assets\AppAsset;
    use app\helpers\RoleNavHelper;

    AceAsset::register($this);

    /* @var $this \yii\web\View */
    /* @var $content string */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-1">
<?php $this->beginBody() ?>

<?php
    NavBar::begin([
        'brandLabel'            => Yii::t('app', 'EndyMed PPD'),
        'brandUrl'              => Yii::$app->homeUrl,
        'brandOptions'          => [
            'class' => 'navbar-header pull-left'
        ],
        'options'               => [
            'id'    => 'navbar',
            'tag'   => 'div',
            'class' => 'navbar navbar-default navbar-fixed-top',
        ],
        'innerContainerOptions' => [
            'class' => 'navbar-container',
            'id'    => 'navbar-container'
        ],
        'containerOptions'      => [
            'class' => 'navbar-buttons navbar-header pull-right',
            'role'  => 'navigation',
        ],
    ]);

    echo RoleNavHelper::profileMenu(Yii::$app->user->isGuest);

    NavBar::end();
?>

<div class="main-container" id="main-container">
    <div id="sidebar" class="sidebar responsive sidebar-fixed sidebar-scroll">
        <?= RoleNavHelper::navigationMenu() ?>
    </div>

    <div class="main-content">
        <div class="page-content">
            <div class="page-content-area">
                <div class="page-header">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <small>                        <?=
                            Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
                    </small>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alerts">
                            <?= FlashAlert::flashArea() ?>
                        </div>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="footer">
        <div class="footer-inner">
            <div class="footer-content">
                <p class="pull-left">&copy; EndyMed <?= date('Y') ?></p>

                <p class="pull-right">Version: <?= Yii::$app->params['version'] ?></p>
            </div>
        </div>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
