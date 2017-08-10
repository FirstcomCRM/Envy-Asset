<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DepositLine */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deposit-line-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'deposit')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
        ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
