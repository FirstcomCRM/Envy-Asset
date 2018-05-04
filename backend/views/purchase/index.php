<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
use common\models\UserManagement;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PurchaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-index">

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
        <div class="table-responsive">
          <?php Pjax::begin(); ?>    <?= GridView::widget([
              'dataProvider' => $dataProvider,
            //  'filterModel' => $searchModel,
              'columns' => [
                  ['class' => 'yii\grid\SerialColumn'],
                  'purchase_no',
                  [
                    'attribute'=>'investor',
                    'value'=>function($model){
                      return Retrieve::retrieveInvestor($model->investor);
                    },
                  ],
                  [
                    'attribute'=>'product',
                    'value'=>function($model){
                      return Retrieve::retrieveProductName($model->product);
                    },
                  ],
                  'share',
                  [
                    'attribute'=>'price',
                    'headerOptions' => ['style'=>'text-align:right'],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'value'=>function($model){
                      return '$'.Retrieve::retrieveFormat($model->price);
                    },
                  ],
                //  'price',
                  [
                    'attribute'=>'date',
                    'format' => ['date', 'php:d M Y'],
                  ],
                  [
                    'attribute'=>'expiry_date',
                    'format' => ['date', 'php:d M Y'],
                  ],
                  [
                    'attribute'=>'salesperson',
                    'value'=>function($model){
                      return Retrieve::retrieveUsernameManagement($model->salesperson);
                    },
                  ],
                  // 'remarks:ntext',

                  ['class' => 'yii\grid\ActionColumn'],
              ],
          ]); ?>
        <?php Pjax::end(); ?>
        </div>

      </div>
    </div>



</div>
