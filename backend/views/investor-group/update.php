<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerGroup */

$this->title = 'Update Investor Group: ' . $model->customer_group;
$this->params['breadcrumbs'][] = ['label' => 'Investor Group', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customer_group, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
