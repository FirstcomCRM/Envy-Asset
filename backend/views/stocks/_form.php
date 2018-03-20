<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Stocks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stocks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'stock')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
      'convertFormat'=>true,
      'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //  'type'=>1,
      'readonly' => true,
      'pluginOptions' => [
        'autoclose'=>true,
      //  'format' => 'php:Y-m-d',
        'format'=>'php:d M Y',
      ],
    ]); ?>

    <?php echo $form->field($model, 'sold_date')->widget(DatePicker::classname(), [
      'convertFormat'=>true,
      'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //  'type'=>1,
      'readonly' => true,
      'pluginOptions' => [
        'autoclose'=>true,
      //  'format' => 'php:Y-m-d',
        'format'=>'php:d M Y',
      ],
    ]); ?>

    <?= $form->field($model, 'sold_units')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buy_units')->textInput(['maxlength' => true]) ?>


    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'add_in')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'buy_in_price')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'sold_price')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'month_end_price')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'unrealized')->textInput(['maxlength' => true]) ?>

      </div>
      <div class="col-md-6">

        <?=$form->field($model, 'add_in_rate')->textInput(['maxlength' => true]) ?>


        <?php $form->field($model, 'add_in_rate',
         [
           'template' => '{label}{input}{error}{hint}',
           'options' => ['class' => 'form-group form-inline']
          ])->textInput(['maxlength' => true]); ?>
          <!---testing phase to inline these forms--->

	      <?php $form->field($model, 'add_in_rate', ['template' => '<div class="col-sm-3 text-right">{label}</div>
								<div class="col-sm-9 col-xs-12">{input}</div>
								{hint}
								{error}'])->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'buy_in_rate')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'sold_price_rate')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'month_end_rate')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'unrealized_rate')->textInput(['maxlength' => true]) ?>

      </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
        ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
