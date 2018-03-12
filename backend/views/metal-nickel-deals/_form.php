<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetalNickelDeals */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-nickel-deals-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-6">
          <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'total_deal_size')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'contract_period')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'purchase_price_a')->textInput(['maxlength' => true, 'onchange'=>'costPrice()']) ?>

          <?= $form->field($model, 'insurance_cost_a')->textInput(['maxlength' => true, 'onchange'=>'costPrice()']) ?>

          <?= $form->field($model, 'forward_price')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'final_sales_price')->textInput(['maxlength' => true, 'onchange'=>'beforeCom()']) ?>
      </div>

      <div class="col-md-6">
        <?= $form->field($model, 'total_cost_price')->textInput(['maxlength' => true, 'readonly'=>'true']) ?>

        <?= $form->field($model, 'unrealised_profit_a')->textInput(['maxlength' => true, 'readonly'=>'true', 'onchange'=>'commission()']) ?>

        <?= $form->field($model, 'commision')->textInput(['maxlength' => true, 'readonly'=>'true']) ?>

        <?= $form->field($model, 'unrealised_profit_b')->textInput(['maxlength' => true, 'readonly'=>'true']) ?>

        <?= $form->field($model, 'net_unrealised')->textInput(['maxlength' => true, 'readonly'=>'true']) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
      </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
