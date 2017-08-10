<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserGroup */

$this->title = 'Update User Group: ' . $model->usergroup;
$this->params['breadcrumbs'][] = ['label' => 'User Group', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->usergroup, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
