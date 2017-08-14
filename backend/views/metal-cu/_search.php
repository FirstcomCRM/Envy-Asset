<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetalCuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-cu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'import_metal_id') ?>

    <?= $form->field($model, 'date_uploaded') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'cu_cash') ?>

    <?php // echo $form->field($model, 'cu_three_month') ?>

    <?php // echo $form->field($model, 'cu_stock') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
