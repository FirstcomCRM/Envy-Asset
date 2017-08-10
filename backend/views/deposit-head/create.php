<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DepositHead */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Deposit Head', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposit-head-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
