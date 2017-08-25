<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealisedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-unrealised-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'import_metal_id') ?>

    <?= $form->field($model, 'date_uploaded') ?>

    <?= $form->field($model, 'commodity') ?>

    <?= $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'entry_date_usd') ?>

    <?php // echo $form->field($model, 'entry_price_usd') ?>

    <?php // echo $form->field($model, 'entry_value_usd') ?>

    <?php // echo $form->field($model, 'exit_date_usd') ?>

    <?php // echo $form->field($model, 'exit_price_usd') ?>

    <?php // echo $form->field($model, 'exit_value_usd') ?>

    <?php // echo $form->field($model, 'realised_gain_usd') ?>

    <?php // echo $form->field($model, 'realised_gain_percent') ?>

    <?php // echo $form->field($model, 'profit_lost_usd') ?>

    <?php // echo $form->field($model, 'profit_lost_sgd') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
