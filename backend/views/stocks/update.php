<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Stocks */

$this->title = 'Update Stock: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invest Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stocks-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
