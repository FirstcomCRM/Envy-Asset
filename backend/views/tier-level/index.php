<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\SideNav;
use yii\helpers\Url;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TierLevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tier Level';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tier-level-index">

    <div class="row">
      <div class="col-md-2">
        <?php echo SideNav::widget([
                'type' => 'info',
                'heading'=>'<i class="fa fa-cog" aria-hidden="true"></i> Tier Level',
                'items'=>[
                    ['label' => 'Tier Level', 'url'=>Url::to(['/tier-level/index'])],
                    ['label' => 'Tier Reduction', 'url'=>Url::to(['/tier-reduction/index'])],
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
            <p class="text-right">
                <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add', ['create'], ['class' => 'btn btn-default']) ?>
            </p>
            <?php Pjax::begin(); ?>
             <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                //    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'tier_level',
                        'connecting_level',
                        'date_added',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
          </div>
        </div>

      </div>
    </div>



</div>
