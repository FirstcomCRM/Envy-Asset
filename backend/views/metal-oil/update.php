<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalOil */

$this->title = 'Update Oil: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Oil', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-oil-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
