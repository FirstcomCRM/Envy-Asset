<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MetalCu */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Copper', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-cu-view">

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
          //  'id',
          //  'import_metal_id',
            'date_uploaded',
            'date',
            'cu_cash',
            'cu_three_month',
            'cu_stock',
        ],
    ]) ?>

</div>
