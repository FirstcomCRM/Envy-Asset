<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Investor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

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
        <div class="text-right">
          <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add', ['create'], ['class' => 'btn btn-default']) ?>
          <?= Html::a('<i class="fa fa-upload" aria-hidden="true"></i> Import', ['import'], ['class' => 'btn btn-success']) ?>
          <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i> Download Template', ['download'], ['class' => 'btn btn-success']) ?>
        </div>
        <br>
          <div class="table-responsive">
            <?php Pjax::begin(); ?>
              <?= GridView::widget([
                'dataProvider' => $dataProvider,
              //  'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'company_name',
                    'nric',
                    'passport_no',
                    'company_registration',
                    'mobile',
                  

                    ['class' => 'yii\grid\ActionColumn'],
                ],
              ]); ?>
            <?php Pjax::end(); ?>
          </div>

      </div>
    </div>

</div>
