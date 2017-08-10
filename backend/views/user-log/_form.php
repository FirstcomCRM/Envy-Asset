<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TblAuditTrail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-audit-trail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'old_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'new_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stamp')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
