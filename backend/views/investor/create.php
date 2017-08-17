<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'Create Investor';
$this->params['breadcrumbs'][] = ['label' => 'Investor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
