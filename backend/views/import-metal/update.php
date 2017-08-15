<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ImportMetal */

$this->title = 'Update Metal Invesstment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metal Investment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="import-metal-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
