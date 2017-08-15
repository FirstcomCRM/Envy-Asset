<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalZn */

$this->title = 'Update Zinc: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Zinc', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-zn-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
