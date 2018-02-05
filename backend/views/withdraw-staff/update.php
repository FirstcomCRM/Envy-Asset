<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Withdraw */

$this->title = 'Withdraw(Staff): ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Withdraw(Staff)', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="withdraw-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
