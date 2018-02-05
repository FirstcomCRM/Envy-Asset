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
                  return '$'.Retrieve::retrieveFormat($model->buy_in_price);
            //    return '$'.$model->buy_in_price;
              },
            ],
            [
              'attribute'=>'sold_price',
              'value'=>function($model){
                $data = number_format($model->sold_price,2);
                return '$'.$data;
              },
            ],
            [
              'attribute'=>'month_end_price',
              'value'=>function($model){
                  return '$'.Retrieve::retrieveFormat($model->month_end_price);
              //  return '$'.$model->month_end_price;
              },
            ],
            [
              'attribute'=>'unrealized',
              'value'=>function($model){
                  return '$'.Retrieve::retrieveFormat($model->unrealized);
            //    return '$'.$model->unrealized;
              },
            ],

          //  'current_market:decimal',
          //  'unrealized:decimal',

        ],
    ]) ?>

</div>
