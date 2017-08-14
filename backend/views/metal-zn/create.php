<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalZn */

$this->title = 'Create Metal Zn';
$this->params['breadcrumbs'][] = ['label' => 'Metal Zns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-zn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
