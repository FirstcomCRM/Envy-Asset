<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DepositHead */

$this->title = 'Update Deposit: ' . $model->customer;
$this->params['breadcrumbs'][] = ['label' => 'Deposit Head', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customer, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deposit-head-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
