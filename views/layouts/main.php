<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => 'yii2upwork',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $user = \Yii::$app->user;
            $isAdmin = $user->can('admin');
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    //  ['label' => 'Home', 'url' => ['/site/index']],
                    //  ['label' => 'About', 'url' => ['/site/about']],
                    //  ['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => 'Admin', 'items' => [
                            ['label' => 'API', 'url' => ['/user']],
                            ['label' => 'Аккаунты', 'url' => ['/user/admin']],
                            ['label' => 'gii', 'url' => ['/gii']],
                        ], 'visible' => $isAdmin], // check if user is an admin 
                    ['label' => 'Transaction', 'url' => ['transaction/transaction'], 'visible' => !Yii::$app->user->isGuest], // check if user is an admin 
                    Yii::$app->user->isGuest ?
                            ['label' => 'Login', 'url' => ['/user/login']] : // or ['/user/login-email']
                            ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                        'url' => ['/user/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; des1roer <?= date('Y') ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
