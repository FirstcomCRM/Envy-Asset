<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\Deposit */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deposit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposit-view">

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
            [
              'attribute'=>'investor',
              'value'=>function($model){
                return Retrieve::retrieveInvestor($model->investor);
              },
            ],
            [
              'attribute'=>'price',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->price);
              },
            ],
            [
              'attribute'=>'category',
              'value'=>function($model){
                return Retrieve::retrieveProductCat($model->category);
              },
            ],
            'date',
            'remarks:ntext',
        ],
    ]) ?>

</div>
