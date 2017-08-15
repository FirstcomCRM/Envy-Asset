<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetalOil */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-oil-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'oil_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oil_open')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oil_high')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oil_low')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oil_change')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
