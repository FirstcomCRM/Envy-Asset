<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseLineSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-line-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'purchase_id') ?>

    <?= $form->field($model, 'psold_date') ?>

    <?= $form->field($model, 'psold_currency') ?>

    <?= $form->field($model, 'pcurrency_rate') ?>

    <?php // echo $form->field($model, 'psold_price') ?>

    <?php // echo $form->field($model, 'psold_units') ?>

    <?php // echo $form->field($model, 'pbalance') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
