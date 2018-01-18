<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $model common\models\StocksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stocks-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
      <div class="col-md-3">
        <?= $form->field($model, 'stock')->textInput(['placeholder'=>'Stocks'])->label(false) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'date')->label(false)->widget(DateRangePicker::classname(), [
          'useWithAddon'=>false,
          'convertFormat'=>true,
          'pluginOptions'=>[
            'locale'=>[
              //'format'=> 'M j Y',
              //'format'=> 'm-d-Y',
              'format'=> 'Y-m-d',
            ],
          ],
          'options'=>[
            'placeholder'=>'Date',
            'class'=>'form-control'
          ],
        ]); ?>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>

            <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>

        </div>

      </div>
    </div>


    <?php // $form->field($model, 'price') ?>

    <?php // $form->field($model, 'add_in') ?>

    <?php // $form->field($model, 'buy_in_price') ?>

    <?php // echo $form->field($model, 'current_market') ?>

    <?php // echo $form->field($model, 'unrealized') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'date_edited') ?>

    <?php // echo $form->field($model, 'added_by') ?>

    <?php // echo $form->field($model, 'edited_by') ?>

    <?php // echo $form->field($model, 'date_added') ?>


    <?php ActiveForm::end(); ?>

</div>
