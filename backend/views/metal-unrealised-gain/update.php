<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealisedGain */

$this->title = 'Update Metal Unrealised Gain/Loss: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metal Unrealised Gain/Loss', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-unrealised-gain-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
