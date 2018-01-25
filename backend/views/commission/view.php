<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\Commission */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Commission Report', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commission-view">

    <p class="text-right">
        <?php Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?php Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['delete', 'id' => $model->id], [
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

            'transact_no',
            [
              'attribute'=> 'transact_date',
              'format' => ['date', 'php:d M Y'],
            ],
            [
              'attribute'=>'sales_person',
              'value'=> function($model){
                return Retrieve::retrieveUsernameManagement($model->sales_person);
              },
            ],
            [
              'attribute'=>'transact_amount',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->transact_amount);
              }
            ],
            [
              'attribute'=>'commision_percent',
              'value'=>function($model){
                return ($model->commision_percent*100).'%';
              },
            ],

            [
              'attribute'=>'commission',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->commission);
              }
            ],
        //    'date_added',
        ],
    ]) ?>

</div>
