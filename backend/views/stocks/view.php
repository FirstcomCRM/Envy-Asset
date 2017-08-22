<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\Stocks */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invest Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-view">


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
            'stock',
            [
              'attribute'=>'price',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->price);
              },
            ],
            'date_created',
            'date_edited',
            [
              'attribute'=>'added_by',
              'value'=>function($model){
                return Retrieve::retrieveUsername($model->added_by);
              },
            ],
            [
              'attribute'=>'edited_by',
              'value'=>function($model){
                return Retrieve::retrieveUsername($model->edited_by);
              },
            ],

        ],
    ]) ?>

</div>
