<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TierReduction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tier-reduction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'highest_percent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reduction_percent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lowest_percent')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
