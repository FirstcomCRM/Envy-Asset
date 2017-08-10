<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AnnouncementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Announcement';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="announcement-index">

    <h1><?= Html::encode($this->title) ?></h1>


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
          <?php Pjax::begin(); ?>
           <?= GridView::widget([
                  'dataProvider' => $dataProvider,
              //    'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      'title',
                    //  'announcement:ntext',
                      'date_created',
                      'date_modified',
                      ['class' => 'yii\grid\ActionColumn'],
                  ],
              ]); ?>
          <?php Pjax::end(); ?>
        </div>

      </div>
    </div>


</div>
