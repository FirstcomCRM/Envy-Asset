<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealisedGain */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metal Unrealised Gain/Loss', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-unrealised-gain-view">

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
            'description',
            [
              'attribute'=>'usd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->usd);
              },
            ],

            [
              'attribute'=>'sgd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->sgd);
              },
            ],
            [
              'attribute'=>'gain_loss',
              'value'=> function($model){
                return $model->gain_loss * 100;
              },
            ],
            're_description',
            [
              'attribute'=>'re_usd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->re_usd);
              },
            ],
            [
              'attribute'=>'re_sgd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->re_sgd);
              },
            ],
            [
              'attribute'=>'re_gain_loss',
              'value'=> function($model){
                return $model->re_gain_loss * 100;
              },
            ],
        ],
    ]) ?>

</div>
