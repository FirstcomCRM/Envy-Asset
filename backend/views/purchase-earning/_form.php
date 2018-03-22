<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseEarning */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-earning-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'purchase_id')->textInput() ?>

    <?= $form->field($model, 'purchase_date')->textInput() ?>

    <?= $form->field($model, 'expiry_date')->textInput() ?>

    <?= $form->field($model, 're_date')->textInput() ?>

    <?= $form->field($model, 're_metal_per')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'purchase_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_earn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_earn_after')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_earn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_earn')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
