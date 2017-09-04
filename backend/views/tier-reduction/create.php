<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TierReduction */

$this->title = 'Create Tier Reduction';
$this->params['breadcrumbs'][] = ['label' => 'Tier Reduction', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tier-reduction-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
