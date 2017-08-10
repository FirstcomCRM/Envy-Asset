<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductManagement */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Product Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-management-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
