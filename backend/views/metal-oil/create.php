<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalOil */

$this->title = 'Create Metal Oil';
$this->params['breadcrumbs'][] = ['label' => 'Metal Oils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-oil-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
