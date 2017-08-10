<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DepositLine */

$this->title = 'Update Deposit Line: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deposit Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deposit-line-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
