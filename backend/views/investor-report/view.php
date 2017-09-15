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
