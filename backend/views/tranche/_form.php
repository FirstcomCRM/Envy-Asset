<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tranche */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tranche-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'min_val')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_val')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
