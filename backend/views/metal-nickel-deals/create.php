<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetalNickelDeals */

$this->title = 'Create Metal Nickel Deal';
$this->params['breadcrumbs'][] = ['label' => 'Metal Nickel Deals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metal-nickel-deals-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
