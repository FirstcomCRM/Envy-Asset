<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ImportMetal */

$this->title = 'Import Metal Investment';
$this->params['breadcrumbs'][] = ['label' => 'Metal Investment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-metal-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
