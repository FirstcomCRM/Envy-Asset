<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Commission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commission-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transact_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transact_date')->textInput() ?>

    <?= $form->field($model, 'sales_person')->textInput() ?>

    <?= $form->field($model, 'commision_percent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commission')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_added')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
