<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserManagement */

$this->title = 'Update User: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-management-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
