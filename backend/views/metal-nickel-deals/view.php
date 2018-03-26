<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\MetalNickelDeals */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Nickel Deals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-nickel-deals-view">

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
      //      'import_metal_id',
              [
                'attribute'=>'date_uploaded',
                'format' => ['date', 'php:d M Y'],
              ],
            'title',
            'description',
            'total_deal_size',
            //'contract_period',
            [
              'attribute'=>'contract_period_start',
              'format' => ['date', 'php:d M Y'],
            ],
            [
              'attribute'=>'contract_period_end',
              'format' => ['date', 'php:d M Y'],
            ],
            [
              'attribute'=>'purchase_price_a',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->purchase_price_a);
              },
            ],
            'pur_curr_a',
            'pur_curr_rate_a',
            [
              'attribute'=>'insurance_cost_a',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->insurance_cost_a);
              },
            ],
            'ins_curr_a',
            'ins_curr_rate_a',
            [
              'attribute'=>'forward_price',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->forward_price);
              },
            ],
          /*  [
              'attribute'=>'final_sales_price',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->final_sales_price);
              },
            ],*/

            [
              'attribute'=>'total_cost_price',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->total_cost_price);
              },
            ],
            [
              'attribute'=>'unrealised_profit_a',
              'value'=>function($model){
                  $numbers= $model->unrealised_profit_a*100;
                  return number_format($numbers,2).'%';
              //  return '$'.Retrieve::retrieveFormat($model->unrealised_profit_a);
              },
            ],
            [
              'attribute'=>'commision',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->commision);
              },
            ],
            [
              'attribute'=>'unrealised_profit_b',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->unrealised_profit_b);
              },
            ],
            //'net_unrealised',
            [
                'attribute'=>'net_unrealised',
                'value'=>function($model){
                //  $data = $model->net_unrealised;
                  return $model->net_unrealised.'%';
                }
            ],
        ],
    ]) ?>

</div>
