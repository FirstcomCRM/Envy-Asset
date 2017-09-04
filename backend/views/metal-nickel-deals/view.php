<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MetalNickelDeals */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Nickel Deals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-nickel-deals-view">

    <p class="text-right">
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        //    'id',
      //      'import_metal_id',
            'date_uploaded',
            'title',
            'description',
            'total_deal_size',
            'contract_period',
            'purchase_price_a',
            'insurance_cost_a',
            'forward_price',
            'final_sales_price',
            'purchase_price_b',
            'insurance_cost_b',
            'total_cost_price',
            'unrealised_profit_a',
            'commision',
            'unrealised_profit_b',
            'net_unrealised',
        ],
    ]) ?>

</div>
