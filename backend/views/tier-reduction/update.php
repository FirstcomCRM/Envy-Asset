<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TierReduction */

$this->title = 'Update Tier Reduction: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tier Reduction', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tier-reduction-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
