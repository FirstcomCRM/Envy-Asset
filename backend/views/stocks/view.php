<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\Stocks */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-view">



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

            'stock',
            [
              'attribute'=>'date',
              'format' => ['date', 'php:d M Y'],
            ],
            [
              'attribute'=>'price',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->price);
              },
            ],
            [
              'attribute'=>'add_in',
              'value'=>function($model){
                return '$'.$model->add_in.'.00';
              },
            ],
            [
              'attribute'=>'buy_in_price',
              'value'=>function($model){
                return '$'.$model->buy_in_price.'.00';
              },
            ],
          //  'current_market:decimal',
          //  'unrealized:decimal',

        ],
    ]) ?>

</div>
