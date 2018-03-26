<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tranche */

$this->title = 'Create Tranche';
$this->params['breadcrumbs'][] = ['label' => 'Tranches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tranche-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
