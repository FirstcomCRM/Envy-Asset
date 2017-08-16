<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CustomerGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Investor Group';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-group-index">

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
        <h3 class="panel-title">Investor Group</h3>
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
                    'customer_group',
                    'description:ntext',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>

</div>
