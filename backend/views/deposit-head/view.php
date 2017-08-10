<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\DepositHead */

$this->title = $model->customer;
$this->params['breadcrumbs'][] = ['label' => 'Deposit Head', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposit-head-view">

    <p class="text-right">
        <?= Html::a('<i class="fa fa-money" aria-hidden="true"></i> Deposit', ['deposit-line/create', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'customer',
            'date_created',
        ],
    ]) ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Deposit</h3>
      </div>
      <div class="panel-body">
        <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
              //  'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute'=>'deposit',
                      'value'=> function($model){
                        return number_format($model->deposit,2);
                      }
                    ],
                    'date_added',
                //    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>

</div>
