<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\Purchase */

?>
<div class="purchase-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'purchase_no',
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
    //          'contentOptions' => ['class' => 'bg-red'],
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->price);
              },
            ],

            [
              'attribute'=>'date',
              'format' => ['date', 'php:d M Y'],
            ],
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
