<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Purchase */

$this->title = 'Update: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase(Staff)', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
