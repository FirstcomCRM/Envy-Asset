<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
use common\models\Withdraw;
use common\models\Deposit;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = $model->company_name;

$this->params['breadcrumbs'][] = $this->title;

$withdraw_sum = 0;
$deposit_sum = 0;

foreach ($withdraw->getModels() as $key => $value) {
  $withdraw_sum += $value->price;
}

foreach ($deposit->getModels() as $key => $value) {
  $deposit_sum += $value->price;
}

?>
<div class="customer-view">

  <ul class="nav nav-tabs">
    <li class="active"><a href="#profile" data-toggle="tab">Investor Profile</a></li>
    <li><a href="#withdraw" data-toggle="tab">Withdrawal Records</a></li>
    <li><a href="#deposit" data-toggle="tab">Deposit Records</a></li>
    <li><a href="#payout" data-toggle="tab">Payout Records</a></li>
    <li><a href="#purchase" data-toggle="tab">Purchase Records</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane fade in active" id="profile">
      <br>
      <?= DetailView::widget([
          'model' => $model,
          'attributes' => [
              'company_name',
              'customer_group',
              'contact_person',
              [
                'attribute'=>'salesperson',
                'value'=>function($model){
                  return Retrieve::retrieveUsernameManagement($model->salesperson);
                },
              ],
              'email:email',
              'mobile',
              'address:ntext',
              'remark:ntext',
              'username',
              [
                'label'=>'Balance',
                'value'=> number_format($deposit_sum - $withdraw_sum,2),
              ],
          ],
      ]) ?>
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
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute'=>'price',
                      'value'=> function($model){
                        return Retrieve::retrieveFormat($model->price);
                      }
                    ],
                    [
                      'attribute'=>'category',
                      'value'=>function($model){
                        return Retrieve::retrieveProductCat($model->category);
                      },
                    ],
                    'date',
                    'remarks:ntext',
                  //  ['class' => 'yii\grid\ActionColumn'],
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
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute'=>'price',
                      'value'=> function($model){
                        return Retrieve::retrieveFormat($model->price);
                      }
                    ],
                    [
                      'attribute'=>'category',
                      'value'=>function($model){
                        return Retrieve::retrieveProductCat($model->category);
                      },
                    ],
                    'date',
                    'remarks:ntext',
                  //  ['class' => 'yii\grid\ActionColumn'],
                ],
              ]); ?>
            <?php Pjax::end(); ?>
          </div>
        </div>
      </div>
    </div><!--End of Deposit pane--->

    <div class="tab-pane fade in" id="payout"><!--Payout of Deposit pane--->
      <br>
      insert payout gridview here
    </div><!--End of Payout pane--->

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
                    'value'=>function($model){
                      return Retrieve::retrieveFormat($model->price);
                    },
                  ],
                  'date',
                  'salesperson',
                  'remarks:ntext',
                //  ['class' => 'yii\grid\ActionColumn'],

              ],
            ]); ?>
            <?php Pjax::end(); ?>
          </div>
        </div>
      </div>
    </div>

  </div><!--End of tab content--->

</div>
