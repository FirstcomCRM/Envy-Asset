<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductCategory */

$this->title = 'Update Category: ' . $model->category;
$this->params['breadcrumbs'][] = ['label' => 'Product Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
