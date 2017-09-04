<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CountryMetalNickelDealsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-nickel-deals-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'import_metal_id') ?>

    <?= $form->field($model, 'date_uploaded') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'total_deal_size') ?>

    <?php // echo $form->field($model, 'contract_period') ?>

    <?php // echo $form->field($model, 'purchase_price_a') ?>

    <?php // echo $form->field($model, 'insurance_cost_a') ?>

    <?php // echo $form->field($model, 'forward_price') ?>

    <?php // echo $form->field($model, 'final_sales_price') ?>

    <?php // echo $form->field($model, 'purchase_price_b') ?>

    <?php // echo $form->field($model, 'insurance_cost_b') ?>

    <?php // echo $form->field($model, 'total_cost_price') ?>

    <?php // echo $form->field($model, 'unrealised_profit_a') ?>

    <?php // echo $form->field($model, 'commision') ?>

    <?php // echo $form->field($model, 'unrealised_profit_b') ?>

    <?php // echo $form->field($model, 'net_unrealised') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
