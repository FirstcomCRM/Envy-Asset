<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseEarning */

$this->title = 'Update Purchase Earning: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Earnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-earning-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
