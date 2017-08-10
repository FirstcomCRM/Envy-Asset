<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserGroup */

$this->title = 'Create User Group';
$this->params['breadcrumbs'][] = ['label' => 'User Group', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
