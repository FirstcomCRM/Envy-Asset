<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\components\Retrieve;

$this->title = 'Investor Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>investor-report/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<div class="investor-report-index">
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
      <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Predefined Update', ['update', 'id'=>3], ['class' => 'btn btn-default modalUpdate']) ?>
        <?= Html::a('<i class="fa fa-wheelchair" aria-hidden="true"></i> Modal Testing Update', FALSE, ['value' => Url::to(['investor-report/update', 'id' => 3]), 'class' => 'btn btn-default','id'=>'modalButton' ]); ?>
      </p>

        <?php Pjax::begin(); ?>
         <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
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
                  'value'=>function($model){
                    return Retrieve::retrieveFormat($model->price);
                  },
                ],
              //  'price',
                'date',
                [
                  'attribute'=>'salesperson',
                  'value'=>function($model){
                    return Retrieve::retrieveUsernameManagement($model->salesperson);
                  },
                ],
                 'remarks:ntext',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      <?php Pjax::end(); ?>
    </div>
  </div>
</div>


<?php
  Modal::begin([
    'header'=>'Update test',
    'id'=>'modal',
    'size'=>'modal-lg',
  //  'closeButton'=>'tag',
  ]);

 ?>

<div class="" id="modalContent">

</div>

<?php Modal::end() ?>
