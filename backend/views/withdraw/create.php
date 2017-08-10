<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WithdrawHead */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Withdraw', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-head-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
