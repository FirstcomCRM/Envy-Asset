<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductType */

$this->title = 'Product Type';
$this->params['breadcrumbs'][] = ['label' => 'Product Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
