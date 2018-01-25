<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-management-index">

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
      <h3 class="panel-title">Product List</h3>
    </div>
    <div class="panel-body">
      <div class="text-right">
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add', ['create'], ['class' => 'btn btn-default']) ?>
      </div>
      <br>
      <div class="table-responsive">
        <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'product_name',
                    'product_code',
                    'description:ntext',
                    [
                      'attribute'=>'product_price',
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'value'=>function($model){
                        return '$'.Retrieve::retrieveFormat($model->product_price);
                      },
                    ],
                    [
                      'attribute'=>'product_cost',
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'value'=>function($model){
                        return '$'.Retrieve::retrieveFormat($model->product_cost);
                      },
                    ],
                    [
                      'attribute'=>'product_cat',
                      'value'=>'cat.category',
                    ],

                /*    [
                      'attribute'=>'product_type',
                      'value'=>'type.type',
                    ],*/



                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>

    </div>
  </div>



</div>
