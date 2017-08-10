<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductManagement */

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Product Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-management-view">

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

            'product_name',
            'description:ntext',
            'product_code',
            'product_price',
            'product_cost',
            'product_type',
            'product_cat',
        ],
    ]) ?>

</div>
