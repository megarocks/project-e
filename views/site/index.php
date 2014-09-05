<?php
    /* @var $this yii\web\View */
    $this->title = Yii::t('app', 'EndyMed PPD');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app', 'EndyMed') ?></h1>

        <p class="lead">Pay Per Date Control Panel</p>

        <p>
            <?php
                if (Yii::$app->user->isGuest):
                    echo '<a class="btn btn-lg btn-success" href="/site/login">' . Yii::t('app', 'Login') . '</a>';
                else:
                    echo '<a class="btn btn-lg btn-primary" href="/site/logout">' . Yii::t('app', 'Logout') . '</a>';
                endif;
            ?>
        </p>
    </div>

    <div class="body-content">

        <div class="row">

        </div>

    </div>
</div>
