<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Deposit */

$this->title = 'Deposit';
$this->params['breadcrumbs'][] = ['label' => 'Deposit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposit-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
