<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealisedGain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-unrealised-gain-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-4">
            <?= $form->field($model, 'usd')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-md-4">
          <?= $form->field($model, 'sgd')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-md-4">
          <?= $form->field($model, 'gain_loss')->textInput(['maxlength' => true]) ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
