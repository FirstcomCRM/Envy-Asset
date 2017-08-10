<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CustomerGroup */

$this->title = 'Customer Group';
$this->params['breadcrumbs'][] = ['label' => 'Customer Group', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
