<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WithdrawHead */

$this->title = 'Update:' . $model->customer;
$this->params['breadcrumbs'][] = ['label' => 'Withdraw', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customer, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="withdraw-head-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
