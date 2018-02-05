<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Purchase */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Purchase(Staff)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
