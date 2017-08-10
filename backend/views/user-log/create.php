<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TblAuditTrail */

$this->title = 'Create Tbl Audit Trail';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Audit Trails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-audit-trail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
