<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StocksLine */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stocks-line-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'stocks_id')->textInput() ?>

    <?= $form->field($model, 'month')->textInput() ?>

    <?= $form->field($model, 'month_curr')->textInput() ?>

    <?= $form->field($model, 'month_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'month_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unrealized_curr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unrealized_local')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
