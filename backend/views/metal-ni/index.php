<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\SideNav;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MetalNiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nickel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-ni-index">

<div class="row">
  <div class="col-md-2">
    <?php echo SideNav::widget([
             'type' => 'info',
             'heading'=>'<i class="fa fa-cog" aria-hidden="true"></i> Nickel',
             'items'=>[
                 ['label' => 'Import', 'url'=>Url::to(['/import-metal/index'])],
                 ['label'=>'Metals', 'items'=>[
                     ['label'=>'Aluminum', 'url'=>Url::to(['/metal-al/index'])],
                     ['label'=>'Copper', 'url'=>Url::to(['/metal-cu/index'])],
                     ['label'=>'Nickel', 'url'=>Url::to(['/metal-ni/index'])],
                     ['label'=>'Zinc', 'url'=>Url::to(['/metal-zn/index'])],
                     ['label'=>'Gold', 'url'=>Url::to(['/metal-au/index'])],
                     ['label'=>'Oil', 'url'=>Url::to(['/metal-oil/index'])],
                   ],
                 ]
                   //insert new menu here
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
        <?php Pjax::begin(); ?>
         <?= GridView::widget([
                'dataProvider' => $dataProvider,
            //    'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                  //  'id',
                //    'import_metal_id',
                    'date_uploaded',
                    'date',
                    'ni_cash',
                    'ni_three_month',
                    'ni_stock',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>




  </div>
</div>


</div>
