<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TblAuditTrail */

$this->title = 'Update Tbl Audit Trail: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Audit Trails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-audit-trail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
