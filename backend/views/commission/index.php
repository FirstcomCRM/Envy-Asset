<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CommissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Commission Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commission-index">


    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Search</h3>
      </div>
      <div class="panel-body">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>

    <?php //if (count($dataProvider->getModels()) != 0): ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">List</h3>
        </div>
        <div class="panel-body">

          <?php Pjax::begin(); ?>
            <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  //'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],

                      'transact_no',

                      [
                        'attribute'=> 'transact_date',
                        'format' => ['date', 'php:d M Y'],
                      ],
                      [
                        'attribute'=>'sales_person',
                        'value'=> function($model){
                          return Retrieve::retrieveUsernameManagement($model->sales_person);
                        },
                      ],
                      [
                        'attribute'=>'commision_percent',
                        'label'=>'Commission %',
                        'value'=>function($model){
                          return ($model->commision_percent*100).'%';
                        },
                      ],
                      [
                        'attribute'=>'transact_amount',
                        'headerOptions' => ['style'=>'text-align:right'],
                        'contentOptions' => ['style' => 'text-align:right'],
                        'value'=>function($model){
                          return '$'.Retrieve::retrieveFormat($model->transact_amount);
                        }
                      ],


                  //    'sales_person',

                      [
                        'attribute'=>'commission',
                        'headerOptions' => ['style'=>'text-align:right'],
                        'contentOptions' => ['style' => 'text-align:right'],
                        'value'=>function($model){
                          return '$'.Retrieve::retrieveFormat($model->commission);
                        }
                      ],

                    //  ['class' => 'yii\grid\ActionColumn'],
                    [
                      'header'=>'Action',
                      'class'=>'yii\grid\ActionColumn',
                      'template'=>'{view}',
                    ],
                  ],
              ]); ?>
          <?php Pjax::end(); ?>
        </div>
      </div>
    <?php //else: ?>
      <!---<div class="alert alert-warning">
        <strong>Warning!</strong> Indicates a warning that might need attention.
      </div>--->
    <?php //endif; ?>



</div>
