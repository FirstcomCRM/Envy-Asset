<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalNi */

$this->title = 'Create Metal Ni';
$this->params['breadcrumbs'][] = ['label' => 'Metal Nis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-ni-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
