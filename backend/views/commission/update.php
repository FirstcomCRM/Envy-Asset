<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Commission */

$this->title = 'Update Commission: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Commission', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="commission-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
