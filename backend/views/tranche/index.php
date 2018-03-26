<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TrancheSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tranches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tranche-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tranche', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // /'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
              'attribute'=>'min_val',
              'value'=>function($model){
                $val = $model->min_val*100;
                return number_format($val,2).'%';
              }
            ],
          
            [
              'attribute'=>'max_val',
              'value'=>function($model){
                $val = $model->max_val*100;
                return number_format($val,2).'%';
              }
            ],
            [
              'attribute'=>'value',
              'value'=>function($model){
                $val = $model->value*100;
                return number_format($val,2).'%';
              }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
