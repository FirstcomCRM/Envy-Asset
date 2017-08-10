<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserManagement */

$this->title = 'Add user';
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-management-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
