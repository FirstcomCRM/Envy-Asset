<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Withdraw */

$this->title = 'Withdraw(Staff)';
$this->params['breadcrumbs'][] = ['label' => 'Withdraw', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
