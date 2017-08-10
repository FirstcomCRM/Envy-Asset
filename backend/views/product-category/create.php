<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductCategory */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Product Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
