<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealised */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-unrealised-form">

    <?php $form = ActiveForm::begin(); ?>

      <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'commodity')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="col-md-4">
          <?php echo $form->field($model, 'entry_date_usd')->widget(DatePicker::classname(), [
            'type'=>3,
            'convertFormat'=>true,
            'readonly' => true,
            'pluginOptions' => [
              'autoclose'=>true,
            //  'format' => 'php:Y-m-d',
              'format' => 'php:m-d-Y',
            ]
          ]); ?>
          <?= $form->field($model, 'entry_price_usd')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'entry_value_usd')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
          <?php $form->field($model, 'exit_date_usd')->textInput() ?>
          <?php echo $form->field($model, 'exit_date_usd')->widget(DatePicker::classname(), [
            'type'=>3,
            'convertFormat'=>true,
            'readonly' => true,
            'pluginOptions' => [
              'autoclose'=>true,
            //  'format' => 'php:Y-m-d',
              'format' => 'php:m-d-Y',
            ]
          ]); ?>
          <?= $form->field($model, 'exit_price_usd')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'exit_value_usd')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'realised_gain_usd')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'realised_gain_percent')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'profit_lost_usd')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'profit_lost_sgd')->textInput(['maxlength' => true]) ?>
          <div class="form-group">
              <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
              ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
          </div>
        </div>
      </div>

    <?php ActiveForm::end(); ?>

</div>
