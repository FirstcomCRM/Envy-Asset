<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Announcement */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Announcement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="announcement-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        //    'id',
            'title',
            'announcement:ntext',
            'date_created',
            'date_modified',
            'created_by',
            'modified_by',
        ],
    ]) ?>

</div>
