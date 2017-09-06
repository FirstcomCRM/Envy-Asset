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
                    'transact_id',
                    'transact_type',
                    [
                      'attribute'=>'transact_amount',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->transact_amount);
                      }
                    ],
                    'transact_date',
                    [
                      'attribute'=>'sales_person',
                      'value'=> function($model){
                        return Retrieve::retrieveUsernameManagement($model->sales_person);
                      },
                    ],
                //    'sales_person',
                    [
                      'attribute'=>'commision_percent',
                      'value'=>function($model){
                        return $model->commision_percent*100;
                      },
                    ],
                    [
                      'attribute'=>'commission',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->commission);
                      }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>


</div>
