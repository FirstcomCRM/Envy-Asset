<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StocksLinea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stocks-linea-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'stocks_id')->textInput() ?>

    <?= $form->field($model, 'sold_date')->textInput() ?>

    <?= $form->field($model, 'sold_currency')->textInput() ?>

    <?= $form->field($model, 'currency_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sold_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sold_units')->textInput() ?>

    <?= $form->field($model, 'balance')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
