<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StocksLineaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stocks-linea-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'stocks_id') ?>

    <?= $form->field($model, 'sold_date') ?>

    <?= $form->field($model, 'sold_currency') ?>

    <?= $form->field($model, 'currency_rate') ?>

    <?php // echo $form->field($model, 'sold_price') ?>

    <?php // echo $form->field($model, 'sold_units') ?>

    <?php // echo $form->field($model, 'balance') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
