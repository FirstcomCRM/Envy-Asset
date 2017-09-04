<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TierLevel */

$this->title = $model->tier_level;
$this->params['breadcrumbs'][] = ['label' => 'Tier Level', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tier-level-view">

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
            'tier_level',
            'connecting_level',
            'date_added',
        ],
    ]) ?>

</div>
