<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseLine */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-line-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'purchase_id')->textInput() ?>

    <?= $form->field($model, 'psold_date')->textInput() ?>

    <?= $form->field($model, 'psold_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pcurrency_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'psold_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'psold_units')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pbalance')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
