<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TblAuditTrailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Log';
$this->params['breadcrumbs'][] = $this->title;

$grid = [
    ['class' => 'yii\grid\SerialColumn'],
    'id',
    [
      'attribute'=>'user_id',
      'label'=>'UserName',
      'value'=>function($model){
        return Retrieve::retrieveUsername($model->user_id);
      }
    ],
    'action',
    'old_value:ntext',
    'new_value:ntext',
    'model',
    'field',
    'stamp',
    'model_id',
    [
      'class'=>'yii\grid\ActionColumn',
      'template'=>'{view}',
    ],
];
?>
<div class="tbl-audit-trail-index">

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
          <p>
            <?php echo ExportMenu::widget([
              'dataProvider' => $dataProvider,
              'columns' => $grid,
              'fontAwesome' => true,
              'initProvider'=>true,
              'exportConfig'=>[
                ExportMenu::FORMAT_TEXT=>false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_HTML=>false,
              ],
              'filename'=>'User-log - '.date('Y-m-d'),
          //  'filename'=>'Quotation Report - '.date('M d Y'),
              'target'=>ExportMenu::TARGET_SELF,
              'showConfirmAlert'=>false,
           ]); ?>
          </p>
        </div>
        <div class="table-responsive">
          <?php Pjax::begin(); ?>
              <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  //'filterModel' => $searchModel,
                  'columns' => $grid,
              ]); ?>
          <?php Pjax::end(); ?>
        </div>
      
      </div>
    </div>


</div>
