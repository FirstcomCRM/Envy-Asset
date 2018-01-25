<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
/* @var $this yii\web\View */
/* @var $model common\models\UserManagement */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-management-view">

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
            'name',

            [
              'attribute'=>'user_group',
              'value'=>function($model){
                return Retrieve::retrieveGroup($model->user_group);
              },
            ],
            [
              'attribute'=>'department',
              'value'=>function($model){
                return Retrieve::retrieveDepartment($model->department);
              },
            ],
            'email:email',
            [
              'attribute'=>'nationality',
              'value'=>function($model){
                return Retrieve::retrieveNationality($model->nationality);
              },
            ],
            'address',
            'mobile',
            'remark:ntext',
            'login_id',
        //    'login_password',
        //  'id',
        //  'user_id',
        ],
    ]) ?>

</div>
