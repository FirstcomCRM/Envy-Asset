<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-management-index">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Search</h3>
      </div>
      <div class="panel-body">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">List</h3>
      </div>
      <div class="panel-body">
        <p class="text-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add', ['create'], ['class' => 'btn btn-default']) ?>
        </p>
        <div class="table-responsive">
          <?php Pjax::begin(); ?>
            <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                //  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      'name',

                      [
                        'attribute'=>'user_group',
                        'value'=>'group.usergroup',
                      ],

                      [
                        'attribute'=>'department',
                        'value'=>'dept.department',
                      ],
                      'email:email',
                  //    'nationality',
                  //    'address',
                  //    'mobile',
                  //    'remark:ntext',
                  //    'login_id',
                      // 'login_password',
                      //  'id',
                      //    'user_id',
                      ['class' => 'yii\grid\ActionColumn'],
                  ],
              ]); ?>
            <?php Pjax::end(); ?>
        </div>
        </div>

    </div>


</div>
