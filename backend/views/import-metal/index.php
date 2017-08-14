<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\SideNav;
use yii\helpers\Url;
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
              'heading'=>'<i class="fa fa-cog" aria-hidden="true"></i> Operations',
              'items'=>[
                  ['label' => 'Main', 'url'=>Url::to(['/import-metal/index'])],
                  ['label'=>'Metals', 'items'=>[
                    ['label'=>'Aluminum', 'url'=>Url::to(['/metal-al/index'])],
                    ['label'=>'Copper', 'url'=>Url::to(['/metal-cu/index'])],
                     ['label'=>'Nickel', 'url'=>Url::to(['/metal-ni/index'])],
                     ['label'=>'Zinc', 'url'=>Url::to(['/metal-zn/index'])],
                    ],
                  ]
                    //insert new menu here
                ],
              ]);
            ?>
    </div>
    <div class="col-md-10">
      <h1><?= Html::encode($this->title) ?></h1>
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

      <p>
        <?= Html::a('Test Import', ['import'], ['class' => 'btn btn-default']) ?>

          <?= Html::a('Create Import Metal', ['create'], ['class' => 'btn btn-success']) ?>
      </p>
      <?php Pjax::begin(); ?>
        <?= GridView::widget([
              'dataProvider' => $dataProvider,
            //  'filterModel' => $searchModel,
              'columns' => [
                  ['class' => 'yii\grid\SerialColumn'],

                  'id',
                  'date_file',
                  'file_name',

                  ['class' => 'yii\grid\ActionColumn'],
              ],
          ]); ?>
      <?php Pjax::end(); ?>
    </div>
  </div>




</div>
