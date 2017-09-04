<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TierReduction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tier Reduction', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tier-reduction-view">

    <p class="text-right">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
          [
            'attribute'=>'highest_percent',
            'value'=> function($model){
              return $model->highest_percent*100;
            },
          ],

          [
            'attribute'=>'reduction_percent',
            'value'=> function($model){
              return $model->reduction_percent*100;
            },
          ],

          [
            'attribute'=>'lowest_percent',
            'value'=> function($model){
              return $model->lowest_percent*100;
            },
          ],
            'date_added',
        ],
    ]) ?>

</div>
