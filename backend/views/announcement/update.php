<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Announcement */

$this->title = 'Update Announcement: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Announcement', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="announcement-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
