<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\WithdrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Withdraw';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-index">

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
            <?= Html::a('<i class="fa fa-money" aria-hidden="true"></i> Withdraw', ['create'], ['class' => 'btn btn-default']) ?>
        </p>
        <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute'=>'investor',
                      'value'=>function($model){
                        return Retrieve::retrieveInvestor($model->investor);
                      },
                    ],
                    [
                      'attribute'=>'price',
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'value'=>function($model){
                          return '$'.Retrieve::retrieveFormat($model->price);
                      },
                    ],

                    [
                      'attribute'=>'category',
                      'value'=>function($model){
                        return Retrieve::retrieveProductCat($model->category);
                      },
                    ],
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
