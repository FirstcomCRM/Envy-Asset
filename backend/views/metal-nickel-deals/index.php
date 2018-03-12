<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\SideNav;
use yii\helpers\Url;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CountryMetalNickelDealsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nickel Deals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-nickel-deals-index">

  <div class="row">
    <div class="col-md-2">
      <?php echo SideNav::widget([
              'type' => 'info',
              'heading'=>'<i class="fa fa-cog" aria-hidden="true"></i> Nickel Deals',
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

        </div>
        <div class="panel-body">
          <p class="text-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add', ['create'], ['class' => 'btn btn-default']) ?>

          </p>
          <?php Pjax::begin(); ?>
           <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                //  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],


                    /*  [
                        'attribute'=>'date_uploaded',
                        'format' => ['date', 'php:d M Y'],
                      ],*/
                      'title',
                      'description',

                      ['class' => 'yii\grid\ActionColumn'],
                  ],
              ]); ?>
          <?php Pjax::end(); ?>
        </div>
      </div>

    </div>
  </div>




</div>
