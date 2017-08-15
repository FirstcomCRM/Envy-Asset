<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalAl */

$this->title = 'Update Aluminum: ' . $model->date;
$this->params['breadcrumbs'][] = ['label' => 'Aluminum', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->date, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-al-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
