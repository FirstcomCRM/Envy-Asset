<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TierReductionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tier-reduction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'highest_percent') ?>

    <?= $form->field($model, 'reduction_percent') ?>

    <?= $form->field($model, 'lowesst_percent') ?>

    <?= $form->field($model, 'date_added') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
