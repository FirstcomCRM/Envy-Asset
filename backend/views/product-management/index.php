<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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
                    'description:ntext',
                    'product_code',
                    'product_price:decimal',
                    'product_cost:decimal',
                    'product_type',
                    'product_cat',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>

    </div>
  </div>



</div>
