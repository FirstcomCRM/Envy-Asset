<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CustomerGroup */

$this->title = 'Investor Group';
$this->params['breadcrumbs'][] = ['label' => 'Investor Group', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
