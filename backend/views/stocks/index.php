<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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
                    'price:decimal',
                    'add_in:decimal',
                    'buy_in_price:decimal',
                    'date',
                    // 'current_market',
                    // 'unrealized',
                    // 'date_created',
                    // 'date_edited',
                    // 'added_by',
                    // 'edited_by',
                    // 'date_added',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>

</div>
