<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductManagement */

$this->title = 'Update Product: ' . $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Product Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-management-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
