<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TierLevel */

$this->title = 'Update Tier Level: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tier Level', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tier_level, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tier-level-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
