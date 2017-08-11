<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalAl */

$this->title = 'Create Metal Al';
$this->params['breadcrumbs'][] = ['label' => 'Metal Als', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-al-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
