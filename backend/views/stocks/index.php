<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\StocksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-index">


    <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title">Search</h3>
      </div>
      <div class="panel-body">
          <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">List</h3>
      </div>
      <div class="panel-body">
        <p class="text-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add', ['create'], ['class' => 'btn btn-default']) ?>
        </p>
        <?php Pjax::begin(); ?>
          <?= GridView::widget([
                'dataProvider' => $dataProvider,
            //    'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'stock',
                    [
                      'attribute'=>'price',
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'value'=>function($model){
                        return '$'.Retrieve::retrieveFormat($model->price);
                      },
                    ],
                    [
                      'attribute'=>'add_in',
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'value'=>function($model){
                        return '$'.$model->add_in.'.00';
                      },
                    ],
                    [
                      'attribute'=>'buy_in_price',
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'value'=>function($model){
                        return '$'.Retrieve::retrieveFormat($model->buy_in_price);
                        //return '$'.$model->buy_in_price.'.00';
                      },
                    ],
                  //  'add_in:decimal',
                //    'buy_in_price:decimal',

                    [
                      'attribute'=>'date',
                      'format' => ['date', 'php:d M Y'],
                    ],


                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>

</div>
