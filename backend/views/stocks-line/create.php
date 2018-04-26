<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StocksLine */

$this->title = 'Create Stocks Line';
$this->params['breadcrumbs'][] = ['label' => 'Stocks Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-line-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
