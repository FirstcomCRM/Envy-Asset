<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductType */

$this->title = 'Update Product Type: ' . $model->type;
$this->params['breadcrumbs'][] = ['label' => 'Product Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->type, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
