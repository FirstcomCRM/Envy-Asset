<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalCu */

$this->title = 'Update Copper: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Copper', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-cu-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
