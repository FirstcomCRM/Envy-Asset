<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\components\Retrieve;
use common\models\Withdraw;
use common\models\Deposit;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Investor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$withdraw_sum = 0;
$deposit_sum = 0;
$purchase_sum = 0;

foreach ($withdraw->getModels() as $key => $value) {
  $withdraw_sum += $value->price;
}

foreach ($deposit->getModels() as $key => $value) {
  $deposit_sum += $value->price;
}

foreach ($purchase->getModels() as $key => $value) {
  $purchase_sum += $value->price;
}


?>
<div class="customer-view">

  <p class="text-right">
      <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Profile', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
      <?= Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete Profile', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-default',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post',
          ],
      ]) ?>
  </p>

  <ul class="nav nav-tabs">
    <li class="active"><a href="#profile" data-toggle="tab">Investor Profile</a></li>
    <li><a href="#withdraw" data-toggle="tab">Withdrawal Records</a></li>
    <li><a href="#deposit" data-toggle="tab">Deposit Records</a></li>
  <!---  <li><a href="#payout" data-toggle="tab">Payout Records</a></li>--->
    <li><a href="#purchase" data-toggle="tab">Purchase Records</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane fade in active" id="profile">
      <br>
      <div class="table-responsive">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'company_name',
              //  'member_code',
                'nric',
                'company_registration',
                'customer_group',
                'contact_person',
                [
                  'attribute'=>'salesperson',
                  'value'=>function($model){
                    return Retrieve::retrieveUsernameManagement($model->salesperson);
                  },
                ],
                'email:email',
                'email_cc:ntext',
                'passport_no',
                'bank_a',
                'bank_b',
                'bank_c',
                'bank_d',
                'bank_e',
                  [
                    'attribute'=>'start_date',
                    'format'=>['date','php:d M Y'],
                  ],
                'mobile',

                'remark:ntext',
                [
                  'label'=>'Balance',
                  'value'=> '$'.number_format($deposit_sum - $withdraw_sum,2),
                ],
            ],
        ]) ?>
      </div>
    </div>

    <div class="tab-pane fade in" id="withdraw"><!--Start of Withdraw pane--->
      <br>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Withdraw</h3>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <?php Pjax::begin(); ?>
              <?= GridView::widget([
                'dataProvider' => $withdraw,
                'showFooter'=>TRUE,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute'=>'price',
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'footerOptions'=>['style' => 'text-align:right'],
                      'footer' => '$'.number_format($withdraw_sum,2),
                      'value'=> function($model){
                        return '$'.Retrieve::retrieveFormat($model->price);
                      }
                    ],
                    [
                      'attribute'=>'product',
                      'value'=>function($model){
                        return Retrieve::retrieveProductName($model->product);
                      },
                    ],
                    [
                      'attribute'=>'date',
                      'format' => ['date', 'php:d M Y'],
                    ],
                    'remarks:ntext',
                  //  ['class' => 'yii\grid\ActionColumn'],
                  [
                    'header'=>'Action',
                   'class'=>'yii\grid\ActionColumn',
                   'template'=>'{view}{update}',
                    'buttons'=>[
                      'view'=>function($url,$model){
                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i> ',$url,['id'=>$model->id, 'title'=>Yii::t('app','View'), 'data-pjax'=>0]);
                      },
                      'update'=>function($url,$model){
                          return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ',$url,['id'=>$model->id, 'title'=>Yii::t('app','Update'), 'data-pjax'=>0]);
                      },
                    ],
                    'urlCreator'=>function($action,$model,$key,$index){
                      if($action==='view'){
                      //  $url='?r=withdraw%2Fview&id='.$model->id;
                        $url = Url::to(['withdraw/view', 'id'=>$model['id']]);
                        return $url;
                      }
                      if($action==='update'){
                    //    $url='?r=withdraw%2Fupdate&id='.$model->id;
                        $url = Url::to(['withdraw/update', 'id'=>$model['id']]);
                        return $url;
                      }

                    }
                  ],
                ],
              ]); ?>

            <?php Pjax::end(); ?>
          </div>
        </div>
      </div>
    </div><!--End of Withdraw pane--->

    <div class="tab-pane fade in" id="deposit"><!--Start of Deposit pane--->
      <br>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Deposit</h3>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <?php Pjax::begin(); ?>
              <?= GridView::widget([
                'dataProvider' => $deposit,
                'showFooter'=>TRUE,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute'=>'price',
                      'headerOptions' => ['style'=>'text-align:right'],
                      'contentOptions' => ['style' => 'text-align:right'],
                      'footerOptions'=>['style' => 'text-align:right'],
                      'footer'=>  '$'.number_format($deposit_sum,2),
                      'value'=> function($model){
                        return '$'.Retrieve::retrieveFormat($model->price);
                      }
                    ],
                    [
                      'attribute'=>'product',
                      'value'=>function($model){
                        return Retrieve::retrieveProductName($model->product);
                      },
                    ],
                    [
                      'attribute'=>'date',
                      'format' => ['date', 'php:d M Y'],
                    ],
                    'remarks:ntext',
                  //  ['class' => 'yii\grid\ActionColumn'],
                  [
                    'header'=>'Action',
                    'class'=>'yii\grid\ActionColumn',
                    'template'=>'{view}{update}',
                    'buttons'=>[
                      'view'=>function($url,$model){
                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i> ',$url,['id'=>$model->id, 'title'=>Yii::t('app','View'), 'data-pjax'=>0]);
                      },
                      'update'=>function($url,$model){
                          return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ',$url,['id'=>$model->id, 'title'=>Yii::t('app','Update'), 'data-pjax'=>0]);
                      },
                    ],
                    'urlCreator'=>function($action,$model,$key,$index){
                      if($action==='view'){
                      //  $url='?r=deposit%2Fview&id='.$model->id;
                        $url = Url::to(['deposit/view', 'id'=>$model['id']]);
                        return $url;
                      }
                      if($action==='update'){
                      //  $url='?r=deposit%2Fupdate&id='.$model->id;
                        $url = Url::to(['deposit/update', 'id'=>$model['id']]);
                        return $url;
                      }

                    }
                  ],
                ],
              ]); ?>
            <?php Pjax::end(); ?>
          </div>
        </div>
      </div>
    </div><!--End of Deposit pane--->

  <!---  <div class="tab-pane fade in" id="payout"><!--Payout of Deposit pane--->
    <!----  <br>
      insert payout gridview here
    </div>--->
    <!--End of Payout pane--->

    <div class="tab-pane fade in" id="purchase">
      <br>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Purchase</h3>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
              'dataProvider' => $purchase,
              'showFooter'=>TRUE,
              'columns' => [
                  ['class' => 'yii\grid\SerialColumn'],
                  [
                    'attribute'=>'product',
                    'value'=>function($model){
                      return Retrieve::retrieveProductName($model->product);
                    },
                  ],
                  'share',
                  [
                    'attribute'=>'price',
                    'headerOptions' => ['style'=>'text-align:right'],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'footerOptions'=>['style' => 'text-align:right'],
                    'footer'=>  '$'.number_format($purchase_sum,2),

                    'value'=>function($model){
                      return Retrieve::retrieveFormat($model->price);
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
                //  ['class' => 'yii\grid\ActionColumn'],
                [
                  'header'=>'Action',
                  'class'=>'yii\grid\ActionColumn',
                  'template'=>'{view}{update}',
                  'buttons'=>[
                    'view'=>function($url,$model){
                      return Html::a('<i class="fa fa-eye" aria-hidden="true"></i> ',$url,['id'=>$model->id, 'title'=>Yii::t('app','View'), 'data-pjax'=>0]);
                    },
                    'update'=>function($url,$model){
                        return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ',$url,['id'=>$model->id, 'title'=>Yii::t('app','Update'), 'data-pjax'=>0]);
                    },

                  ],
                  'urlCreator'=>function($action,$model,$key,$index){
                    if($action==='view'){
                    //  $url='?r=purchase%2Fview&id='.$model->id;
                      $url = Url::to(['purchase/view', 'id'=>$model['id']]);
                      return $url;
                    }
                    if($action==='update'){
                    //  $url='?r=purchase%2Fupdate&id='.$model->id;
                      $url = Url::to(['purchase/update', 'id'=>$model['id']]);
                      return $url;
                    }

                  }
                ],
              ],
            ]); ?>
            <?php Pjax::end(); ?>
          </div>

        </div>
      </div>
    </div>

  </div><!--End of tab content--->

</div>
