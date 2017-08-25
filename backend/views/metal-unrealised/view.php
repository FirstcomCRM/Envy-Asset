<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealised */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metal Unrealised', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-unrealised-view">

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

            //'date_uploaded',
            'commodity',
            'position',
            [
              'attribute'=>'entry_date_usd',
              'value'=>function($model){
                return Retrieve::retrieveDate_mdy($model->entry_date_usd);
              },
            ],
            [
              'attribute'=>'entry_price_usd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->entry_price_usd);
              },
            ],
            [
              'attribute'=>'entry_value_usd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->entry_value_usd);
              },
            ],
            [
              'attribute'=>'exit_date_usd',
              'value'=>function($model){
                  return Retrieve::retrieveDate_mdy($model->exit_date_usd);
              },
            ],
            [
              'attribute'=>'exit_price_usd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->exit_price_usd);
              },
            ],
            [
              'attribute'=>'exit_value_usd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->exit_value_usd);
              },
            ],
            [
              'attribute'=>'realised_gain_usd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->realised_gain_usd);
              },
            ],
            [
              'attribute'=>'realised_gain_percent',
              'value'=>function($model){
                return $model->realised_gain_percent * 100;
              },
            ],
            [
              'attribute'=>'profit_lost_usd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->profit_lost_usd);
              },
            ],
            [
              'attribute'=>'profit_lost_sgd',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->profit_lost_sgd);
              },
            ],
        ],
    ]) ?>

</div>
