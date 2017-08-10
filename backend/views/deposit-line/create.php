<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DepositLine */

$this->title = 'Deposit';
$this->params['breadcrumbs'][] = ['label' => 'Deposit Line', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposit-line-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
