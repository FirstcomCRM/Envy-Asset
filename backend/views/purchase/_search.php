<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

      <div class="row">
        <div class="col-md-3">
          <?= $form->field($model, 'investor')->textInput(['placeholder'=>'Investor'])->label(false) ?>
        </div>
        <div class="col-md-3">
          <?= $form->field($model, 'product')->textInput(['placeholder'=>'Product'])->label(false) ?>
        </div>
        <div class="col-md-3">
          <?php // echo $form->field($model, 'date') ?>
          <div class="form-group">
              <?= Html::submitButton('<i class="fa fa-undo" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
              <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
          </div>
        </div>
        <div class="col-md-3">

        </div>
      </div>

    <?php ActiveForm::end(); ?>

</div>
