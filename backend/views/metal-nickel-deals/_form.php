<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
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

          <?php $form->field($model, 'contract_period')->textInput(['maxlength' => true]) ?>

          <?php echo $form->field($model, 'contract_period_start')->widget(DatePicker::classname(), [
          //  'options' => ['id' => 'purchase_date'],
          //  'value' => '08/10/2004',
            'convertFormat'=>true,
            'readonly' => true,
            'pluginOptions' => [
              'autoclose'=>true,
            //  'format' => 'mm/dd/yyyy'
              'format' => 'php:d M Y',
            ]
          ]); ?>

          <?php echo $form->field($model, 'contract_period_end')->widget(DatePicker::classname(), [
          //  'options' => ['id' => 'purchase_date'],
          //  'value' => '08/10/2004',
            'convertFormat'=>true,
            'readonly' => true,
            'pluginOptions' => [
              'autoclose'=>true,
            //  'format' => 'mm/dd/yyyy'
              'format' => 'php:d M Y',
            ]
          ]); ?>

          <?= $form->field($model, 'purchase_price_a')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'pur_curr_a')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'pur_curr_rate_a')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'insurance_cost_a')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'ins_curr_a')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'ins_curr_rate_a')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'forward_price')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'forward_currency')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'forward_currency_rate')->textInput(['maxlength' => true]) ?>

          <?php $form->field($model, 'final_sales_price')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'final_sales_price_per')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'commission_per')->textInput(['maxlength' => true]) ?>

      </div>

      <div class="col-md-6">
        <?php $form->field($model, 'total_cost_price')->textInput(['maxlength' => true, 'readonly'=>'true']) ?>
        <?php echo $form->field($model, 'total_cost_price')->hiddenInput(['maxlength' => true, 'readonly'=>'true'])->label(false) ?>
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
