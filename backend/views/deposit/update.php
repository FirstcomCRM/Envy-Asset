<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Deposit */

$this->title = 'Update Deposit: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deposit', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deposit-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
