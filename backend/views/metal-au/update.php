<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalAu */

$this->title = 'Update Gold: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gold', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-au-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
