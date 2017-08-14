<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MetalZn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metal Zns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-zn-view">

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
            'import_metal_id',
            'date_uploaded',
            'date',
            'zn_cash',
            'zn_three_month',
            'zn_stock',
        ],
    ]) ?>

</div>
