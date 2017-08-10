<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
            'user_group',
            'department',
            'email:email',
            'nationality',
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
