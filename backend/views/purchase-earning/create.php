<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PurchaseEarning */

$this->title = 'Create Purchase Earning';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Earnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-earning-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
