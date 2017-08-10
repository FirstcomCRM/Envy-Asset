<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
    <li class="active"><a href="#profile" data-toggle="tab">Customer Profile</a></li>
    <li><a href="#withdraw" data-toggle="tab">Withdrawal Records</a></li>
    <li><a href="#deposit" data-toggle="tab">Deposit Records</a></li>
    <li><a href="#payout" data-toggle="tab">Payout Records</a></li>
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
              'email:email',
              'mobile',
              'address:ntext',
              'remark:ntext',
          ],
      ]) ?>
    </div>
    <div class="tab-pane fade" id="withdraw"> <!--Start of Withdraw pane--->

      <br>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Withdraw</h3>
        </div>
        <div class="panel-body">
          <?php Pjax::begin(); ?>
            <?= GridView::widget([
                  'dataProvider' => $dataWithdraw,
                //  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      [
                        'attribute'=>'withdraw',
                        'label'=>'Withdraw',
                        'value'=> function($model){
                            return number_format($model->withdraw,2);
                        },
                      ],
                      'date_added',
                    //  ['class' => 'yii\grid\ActionColumn'],
                  ],
              ]); ?>
          <?php Pjax::end(); ?>
        </div>
      </div>

    </div><!--End of Withdraw pane--->
    <div class="tab-pane fade" id="deposit"><!--Start of Deposit pane--->

      <br>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Deposit</h3>
        </div>
        <div class="panel-body">
          <?php Pjax::begin(); ?>
            <?= GridView::widget([
                  'dataProvider' => $deposit,
                //  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      [
                        'attribute'=>'deposit',
                        'label'=>'Deposit',
                        'value'=> function($model){
                            return number_format($model->deposit,2);
                        },
                      ],
                      'date_added',
                    //  ['class' => 'yii\grid\ActionColumn'],
                  ],
              ]); ?>
          <?php Pjax::end(); ?>
        </div>
      </div>

    </div><!--End of Deposit pane--->
    <div class="tab-pane fade" id="payout"> <!--Start of payout pane--->
      <h3>insert payout records file here</h3>
    </div>
  </div><!--End of payout pane--->






</div>
