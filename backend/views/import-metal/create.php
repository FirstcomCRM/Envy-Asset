<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ImportMetal */

$this->title = 'Import Metal';
$this->params['breadcrumbs'][] = ['label' => 'Import Metal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-metal-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
