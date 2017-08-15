<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetalNi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-ni-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

    <?= $form->field($model, 'ni_cash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ni_three_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ni_stock')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
         ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
