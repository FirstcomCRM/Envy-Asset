<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\SideNav;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MetalUnrealisedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Metal Unrealised';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="metal-unrealised-index">


  <div class="row">
    <div class="col-md-2">
      <?php echo SideNav::widget([
            'type' => 'info',
            'heading'=>'<i class="fa fa-cog" aria-hidden="true"></i> Transactions',
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
            <h3 class="panel-title">List</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <?php Pjax::begin(); ?>
                <?= GridView::widget([
                      'dataProvider' => $dataProvider,
                    //  'filterModel' => $searchModel,
                      'columns' => [
                          ['class' => 'yii\grid\SerialColumn'],

                        //  'date_uploaded',
                          'commodity',
                          'position',
                            [
                              'attribute'=>'entry_date_usd',
                              'value'=>function($model){
                                return Retrieve::retrieveDate_mdy($model->entry_date_usd);
                              },
                            ],
                           [
                             'attribute'=>'entry_price_usd',
                             'value'=>function($model){
                               return Retrieve::retrieveFormat($model->entry_price_usd);
                             },
                           ],
                           [
                             'attribute'=>'entry_value_usd',
                             'value'=>function($model){
                               return Retrieve::retrieveFormat($model->entry_value_usd);
                             },
                           ],

                          ['class' => 'yii\grid\ActionColumn'],
                      ],
                  ]); ?>
              <?php Pjax::end(); ?>
            </div>

          </div>
        </div>

    </div>
  </div>


</div>
