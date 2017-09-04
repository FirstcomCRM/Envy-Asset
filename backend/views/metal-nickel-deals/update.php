<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetalNickelDeals */

$this->title = 'Update Metal Nickel Deal: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Metal Nickel Deals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metal-nickel-deals-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
