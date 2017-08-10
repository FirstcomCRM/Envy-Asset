<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Announcement */

$this->title = 'Create Announcement';
$this->params['breadcrumbs'][] = ['label' => 'Announcement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="announcement-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
