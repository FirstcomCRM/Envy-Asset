<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TblAuditTrail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Log', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-audit-trail-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'old_value:ntext',
            'new_value:ntext',
            'action',
            'model',
            'field',
            'stamp',
            'user_id',
            'model_id',
        ],
    ]) ?>

</div>
