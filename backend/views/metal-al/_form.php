<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetalAl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-al-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'import_metal_id')->textInput() ?>

    <?= $form->field($model, 'date_uploaded')->textInput() ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'al_cash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'al_three_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'al_stocl')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
