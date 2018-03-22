<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseEarning */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Earnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-earning-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'purchase_id',
            'purchase_date',
            'expiry_date',
            're_date',
            're_metal_per',
            'purchase_amount',
            'customer_earn',
            'customer_earn_after',
            'company_earn',
            'staff_earn',
        ],
    ]) ?>

</div>
