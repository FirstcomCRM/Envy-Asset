<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\components\Retrieve;

$this->title = 'Investor Report Alt';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="investor-report-index">

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Search</h3>
    </div>
    <div class="panel-body">
        <?php  echo $this->render('_altersearch', ['model' => $searchModel]); ?>
        <!---
        <div id="email-div">
        <?php Html::checkbox('confirm', false, ['label' => 'Confirm Report' ,'class'=>'email-checkbox']); ?>

          <?php  Html::a('<i class="fa fa-envelope-open" aria-hidden="true"></i> Send to all Investor',
          ['compose-email'],['class' => 'btn btn-warning send-email', 'id'=>'email-button']) ?>
        </div>
        --->

    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">List</h3>
    </div>
    <div class="panel-body">
      <p>
        <?php Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Predefined Update', ['update', 'id'=>3], ['class' => 'btn btn-default modalUpdate']) ?>
        <?php Html::a('<i class="fa fa-wheelchair" aria-hidden="true"></i> Modal Testing Update', FALSE, ['value' => Url::to(['investor-report/update', 'id' => 3]), 'class' => 'btn btn-default modalButton','id'=>'modalButton' ]); ?>
      </p>

        <?php Pjax::begin(['id'=>'investor', 'linkSelector'=>false]); ?>
         <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

              'company_name',
              'nric',
              [
                'header'=>'Action',
                'class'=>'yii\grid\ActionColumn',
              //   'template'=>'{view}{update}{download-pdf}{email}',
                'template'=>'{download-pdf}',
                'options'=>['style'=>'padding:5px'],
                'buttons'=>[
                  'download-pdf'=>function($url,$model,$key){
                          return Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', ['alter-download','id'=>$key], ['title'=>'Download PDF', 'target'=>'_blank']);
                    //  return Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', $url, ['title'=>'Download PDF' ,'id'=>'test']);
                  },
                ],
              ],


            ],
        ]); ?>
      <?php Pjax::end(); ?>
    </div>
  </div>
</div>
