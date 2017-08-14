<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalCu */

$this->title = 'Create Metal Cu';
$this->params['breadcrumbs'][] = ['label' => 'Metal Cus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-cu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
