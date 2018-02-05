<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\SideNav;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ImportMetalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Import Metals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-metal-index">

  <div class="row">
    <div class="col-md-2">
      <?php echo SideNav::widget([
             'type' => 'info',
             'heading'=>'<i class="fa fa-cog" aria-hidden="true"></i> Metal Investment',
             'items'=>[
                 ['label' => 'Import', 'url'=>Url::to(['/import-metal/index'])],
                 ['label'=>'Metal Prices', 'items'=>[
                     ['label'=>'Aluminum', 'url'=>Url::to(['/metal-al/index'])],
                     ['label'=>'Copper', 'url'=>Url::to(['/metal-cu/index'])],
                     ['label'=>'Nickel', 'url'=>Url::to(['/metal-ni/index'])],
                     ['label'=>'Zinc', 'url'=>Url::to(['/metal-zn/index'])],
                     ['label'=>'Gold', 'url'=>Url::to(['/metal-au/index'])],
                     ['label'=>'Oil', 'url'=>Url::to(['/metal-oil/index'])],
                   ],
                 ],
                  ['label'=>'Metals', 'items'=>[
                      ['label' => 'Transactions', 'url'=>Url::to(['/metal-unrealised/index'])],
                      ['label' => 'Gain/Loss', 'url'=>Url::to(['/metal-unrealised-gain/index'])],
                    ],
                  ],
                  ['label' => 'Nickel Deals', 'url'=>Url::to(['/metal-nickel-deals/index'])],
                  //insert new menu here
                //  ['label' => 'New Menu', 'url'=>Url::to(['/metal-unrealised/index'])],
               ],

             ]);
           ?>
    </div>
    <div class="col-md-10">

      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Actions</h3>
        </div>
        <div class="panel-body">
          <p>
            <?php echo Html::a('<i class="fa fa-file-excel-o" aria-hidden="true"></i> Truncate Metal', ['truncate'], ['class' => 'btn btn-danger']) ?>
            <?php echo ButtonDropdown::widget([
              'label' => 'Import',
              'options'=>['class'=>'btn btn-primary'],
              'dropdown' => [
                'items' => [
                  ['label' => 'Base Metals', 'url' => Url::to(['/import-metal/base-metal']) ],
                  ['label' => 'Nickel Deals', 'url' => Url::to(['/import-metal/nickel-deal'])],
                  ['label' => 'Stocks', 'url' => '#'],
                ],
              ],
            ]); ?>
            <?php echo  Html::a('<i class="fa fa-file-excel-o" aria-hidden="true"></i> Download Template', ['download'], ['class' => 'btn btn-success']) ?>

            <?php Html::a('<i class="fa fa-file-excel-o" aria-hidden="true"></i> Import-test', ['import'], ['class' => 'btn btn-default']) ?>
            <?php Html::a('<i class="fa fa-file-excel-o" aria-hidden="true"></i> Import', ['create'], ['class' => 'btn btn-default']) ?>

          </p>
          <?php Pjax::begin(); ?>
            <?php GridView::widget([
                  'dataProvider' => $dataProvider,
                //  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],

                    //  'id',
                    [
                      'attribute'=>'date_file',
                      'format' => ['date', 'php:d M Y'],
                    ],
                      'file_name',

                      ['class' => 'yii\grid\ActionColumn'],
                  ],
              ]); ?>
          <?php Pjax::end(); ?>
        </div>
      </div>

    </div>
  </div>




</div>
