<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealised */

$this->title = 'Update Metal Unrealised: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metal Unrealised', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-unrealised-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
