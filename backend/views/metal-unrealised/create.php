<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealised */

$this->title = 'Create Metal Unrealised';
$this->params['breadcrumbs'][] = ['label' => 'Metal Unrealiseds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-unrealised-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
