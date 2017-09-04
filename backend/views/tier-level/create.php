<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TierLevel */

$this->title = 'Create Tier Level';
$this->params['breadcrumbs'][] = ['label' => 'Tier Level', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tier-level-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
