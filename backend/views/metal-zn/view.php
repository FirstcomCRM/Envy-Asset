<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MetalZn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Zinc', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-zn-view">

    <p class="text-right">
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

        
            'date',
            [
               'attribute'=>'zn_cash',
               'value'=>function($model){
                 return Retrieve::get_numberFormat($model->zn_cash);
               }
           ],
           [
               'attribute'=>'zn_three_month',
               'value'=>function($model){
                 return Retrieve::get_numberFormat($model->zn_three_month);
               }
           ],
           [
               'attribute'=>'zn_stock',
               'value'=>function($model){
                 return Retrieve::get_numberFormat($model->zn_stock);
               }
           ],
        ],
    ]) ?>

</div>
