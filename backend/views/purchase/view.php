<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\Purchase */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-view">

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
          'id',
          [
            'attribute'=>'investor',
            'value'=>function($model){
              return Retrieve::retrieveInvestor($model->investor);
            },
          ],
          [
            'attribute'=>'product',
            'value'=>function($model){
              return Retrieve::retrieveProductName($model->product);
            },
          ],
            'share',
            [
              'attribute'=>'price',
              'value'=>function($model){
                return Retrieve::retrieveFormat($model->price);
              },
            ],
            'date',
            [
              'attribute'=>'salesperson',
              'value'=>function($model){
                return Retrieve::retrieveUsernameManagement($model->salesperson);
              },
            ],
            'remarks:ntext',
        ],
    ]) ?>

</div>
