<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WithdrawLine */

$this->title = 'Withdraw Line';
$this->params['breadcrumbs'][] = ['label' => 'Withdraw Line', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-line-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
