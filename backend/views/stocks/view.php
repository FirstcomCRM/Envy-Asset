<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
use common\models\Investor;
use common\models\Forex;

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

            'buy_units',

            [
              'attribute'=>'forex',
              'value'=>function($model){
                $data = Forex::find()->where(['id'=>$model->forex])->one();
                return $data->currency_code;
              }
            ],

            [
              'attribute'=>'buy_in_price',
              'value'=>function($model){
                  return '$'.Retrieve::retrieveFormat($model->buy_in_price);
            //    return '$'.$model->buy_in_price;
              },
            ],

            [
              'attribute'=>'buy_in_rate',
              'value'=>function($model){
                  return '$'.Retrieve::retrieveFormat($model->buy_in_rate);
            //    return '$'.$model->unrealized;
              },
            ],

            [
              'attribute'=>'buy_in_local',
              'value'=>function($model){
                  return '$'.Retrieve::retrieveFormat($model->buy_in_local);
            //    return '$'.$model->unrealized;
              },
            ],




        ],
    ]) ?>

    <hr>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Stock Details</h3>
      </div>
      <div class="panel-body">
        <?php Pjax::begin(); ?>
          <?= GridView::widget([
                'dataProvider' => $modelLine,
            //    'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                      'attribute'=>'month',
                      'value'=>function($model){
                        return Retrieve::retrieveDate_dmy($model->month);
                      }
                    ],

                    [
                      'attribute'=>'month_curr',
                      'value'=>function($model){
                        $data = Forex::find()->where(['id'=>$model->month_curr])->one();
                        return $data->currency_code;
                      }
                    ],
                  //  'month_price:decimal',
                    [
                      'attribute'=>'month_price',
                      'format'=>['decimal',2],
                    ],
                    [
                      'attribute'=>'month_rate',
                      'format'=>['decimal',2],
                    ],
                    [
                      'attribute'=>'unrealized_curr',
                      'format'=>['decimal',2],
                    ],
                    [
                      'attribute'=>'unrealized_local',
                      'format'=>['decimal',2],
                    ],

                  //  'month_rate:decimal',
                  //  'unrealized_curr:decimal',
                  //  'unrealized_local:decimal',
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Purchase History</h3>
      </div>
      <div class="panel-body">
        <?php Pjax::begin(); ?>
          <?= GridView::widget([
                'dataProvider' => $purchaseData,
            //    'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'purchase_no',
                    [
                      'attribute'=>'investor',
                      'value'=>function($model){
                        $data = Investor::findOne($model->investor);
                        return $data->nric_comp;
                      }
                    ],
                    [
                      'attribute'=>'price',
                      'format'=>['decimal',2],
                    ],

                    [
                      'attribute'=>'sold_currency',
                      'value'=>function($model){
                        $data = Forex::find()->where(['id'=>$model->sold_currency])->one();
                        if (!empty($data) ) {
                          return $data->currency_code;
                        }else{
                          return null;
                        }

                      }
                    ],

                    [
                      'attribute'=>'sold_price',
                      'format'=>['decimal',2],
                    ],
                    [
                      'attribute'=>'sold_price_rate',
                      'format'=>['decimal',2],
                    ],
                    [
                      'attribute'=>'customer_earn',
                      'format'=>['decimal',2],
                    ],

                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>

</div>
