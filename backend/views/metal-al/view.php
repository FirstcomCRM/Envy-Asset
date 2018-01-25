<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\MetalAl */

$this->title = $model->date;
$this->params['breadcrumbs'][] = ['label' => 'Aluminum', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-al-view">

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
            'attribute'=>'al_cash',
            'value'=>function($model){
              return '$'.Retrieve::get_numberFormat($model->al_cash);
            }
          ],

          [
            'attribute'=>'al_three_month',
            'value'=>function($model){
              return '$'.Retrieve::get_numberFormat($model->al_three_month);
            }
          ],

          [
            'attribute'=>'al_stocl',
            'value'=>function($model){
              return '$'.Retrieve::get_numberFormat($model->al_stocl);
            }
          ],
        ],
    ]) ?>

</div>
