<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\SideNav;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MetalOilSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-oil-index">


    <div class="row">
      <div class="col-md-2">
        <?php echo SideNav::widget([
            'type' => 'info',
            'heading'=>'<i class="fa fa-cog" aria-hidden="true"></i> Oil',
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
            <div class="table-responsive">
              <?php Pjax::begin(); ?>
                  <?= GridView::widget([
                      'dataProvider' => $dataProvider,
                      //'filterModel' => $searchModel,
                      'columns' => [
                          ['class' => 'yii\grid\SerialColumn'],

                          'date',
                          

                          [
                            'attribute'=>'oil_price',
                            'value'=>function($model){
                              return '$'.$model->oil_price;
                            }
                          ],
                          [
                            'attribute'=>'oil_open',
                            'value'=>function($model){
                              return '$'.$model->oil_open;
                            }
                          ],
                          [
                            'attribute'=>'oil_high',
                            'value'=>function($model){
                              return '$'.$model->oil_high;
                            }
                          ],
                          [
                            'attribute'=>'oil_low',
                            'value'=>function($model){
                              return '$'.$model->oil_price;
                            }
                          ],
                          'oil_volume',
                          'oil_change',

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
