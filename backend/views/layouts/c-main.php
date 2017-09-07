<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\web\View;
use kartik\nav\NavX;
use common\models\User;

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
    <link rel="icon" href="favicon.ico" type="image/ico">
</head>

<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php $investor = User::find()->where(['id'=>Yii::$app->user->id])->one(); ?>

    <?php
    NavBar::begin([
        'brandLabel' => 'Envy',
      //  'brandUrl' => Yii::$app->homeUrl,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top navbar-nav',
        ],

    ]);


    $menuItems = [];
    if (Yii::$app->user->isGuest) {
//      $menuItems = [['label' => 'About', 'url' => ['/site/about']],
  //    ['label' => 'Contact', 'url' => ['/site/contact']],

    //];
    } else {
      $menuItems = [
            ['label'=>'Investor Profile', 'url'=>['/investor/c-view','id'=>$investor->customer_id]],


        //insert
      ];
      }

    if  (Yii::$app->user->isGuest) {
      //  $menuItems1[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems1[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems1[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }


    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => $menuItems,
    ]);

    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav navbar-right'],
        'items' => $menuItems1,
    ]);


    NavBar::end();
    ?>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<!---
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
--->




<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
