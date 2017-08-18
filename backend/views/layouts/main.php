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
            ['label' => 'Management', 'items'=>[
            ['label'=>'Product Management', 'url'=>['/product-management/index']],
            ['label'=>'Investor Management', 'url'=>['/investor/index']],
            ['label'=>'User Management', 'url'=>['/user-management/index']],

        //    '<li class="divider"></li>',
          //  ['label'=>'Test2', 'url'=>'#'],
          ]
      ],
          ['label'=>'Transactions', 'class'=>'navbars', 'items'=>[
            ['label'=>'Metal Investment', 'url'=>['/import-metal/index']],
            ['label'=>'Stock Investment', 'url'=>['/invest-stock/index']],
            ['label'=>'Withdrawal', 'url'=>['/withdraw/index']],
            ['label'=>'Deposit', 'url'=>['/deposit-head/index']],
            ['label'=>'Purchase', 'url'=>['/purchase/index']],
        ],
      ],
          ['label'=>'Reports', 'class'=>'navbars', 'items'=>[
          //  ['label'=>'User Log Files', 'url'=>['/user-log/index']],
            ['label'=>'Investment Overview', 'url'=>['toollist/index']],
            ['label'=>'Commision Report', 'url'=>['toollist/index']],
            ['label'=>'Customer Report', 'url'=>['toollist/index']],
        ],
      ],
        ['label'=>'Setup', 'class'=>'navbars', 'items'=>[
          ['label'=>'User Rights', 'url'=>['user-permission/permission-setting']],
          ['label'=>'Investor Group', 'url'=>['investor-group/index']],
          ['label'=>'Tier Management', 'url'=>['delivery-order/index']],
          '<li class="divider"></li>',
          ['label'=>'Gii', 'url'=>['gii/default']],
          ['label'=>'Annoucement', 'url'=>['announcement/index']],
          ],
        ],

          ['label'=>'Misc', 'class'=>'navbars', 'items'=>[
          ['label'=>'User group', 'url'=>['/user-group/index']],
          ['label'=>'Department', 'url'=>['/department/index']],
          ['label'=>'Product Type', 'url'=>['/product-type/index']],
          ['label'=>'Product Category', 'url'=>['/product-category/index']],
          ['label'=>'Country', 'url'=>['/country/index']],

        ],
      ],

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
