<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PurchaseEarningSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Commission Future Metal';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-earning-index">

    <div class="panel panel-default">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>


    <div class="panel panel-default">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

              //  'ids',
              //  'purchase_id',
            //    're_date',
                [
                  'attribute'=>'re_date',
                  'label'=>'Year-Month',
                  'format' => ['date', 'php:M Y'],
                ],
                [
                  'attribute'=>'customer_earn',
                  'label'=>'Monthly Returns',
                  'value'=>function($model){
                    return '$'.Retrieve::retrieveFormat($model['customer_earn']);
                  }
                ],
                [
                  'attribute'=>'re_metal_per',
                  'label'=>'Cumulative Returns %',
                  'value'=>function($model){
                      $number = 100*$model['re_metal_per'];
                      return number_format($number,2).'%';
                  },
                ],
                [
                  'attribute'=>'purchase_amount',
                  'label'=>'Balance at the end of the month',
                  'value'=>function($model){
                    return '$'.Retrieve::retrieveFormat($model['purchase_amount']);
                  },
                ],
                [
                  'attribute'=>'company_earn',
                  'label'=>'Commission for the Month',
                  'value'=>function($model){
                    return '$'.Retrieve::retrieveFormat($model['company_earn']);
                  }
                ],
                [
                  'attribute'=>'tranche',
                  'label'=>'Commission Tranche',
                  'value'=>function($model){
                    $number = 100*$model['tranche'];
                    return number_format($number,2).'%';
                  //  return Retrieve::retrieveFormat($model['tranche']);
                  }
                ],

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
    </div>

</div>
