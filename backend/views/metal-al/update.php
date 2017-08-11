<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalAl */

$this->title = 'Update Metal Al: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metal Als', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-al-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
