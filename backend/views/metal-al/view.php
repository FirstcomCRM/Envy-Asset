<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MetalAl */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metal Als', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-al-view">

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
            'al_cash',
            'al_three_month',
            'al_stocl',
        ],
    ]) ?>

</div>
