<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StocksLine */

$this->title = 'Update Stocks Line: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Stocks Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stocks-line-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
