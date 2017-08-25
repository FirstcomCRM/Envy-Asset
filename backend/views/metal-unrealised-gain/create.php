<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealisedGain */

$this->title = 'Create Metal Unrealised Gain';
$this->params['breadcrumbs'][] = ['label' => 'Metal Unrealised Gains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-unrealised-gain-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
