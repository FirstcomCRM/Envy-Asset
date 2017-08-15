<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalAu */

$this->title = 'Create Metal Au';
$this->params['breadcrumbs'][] = ['label' => 'Metal Aus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-au-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
