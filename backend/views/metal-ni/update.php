<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalNi */

$this->title = 'Update Nickel: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nickel', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-ni-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
