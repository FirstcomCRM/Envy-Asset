<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetalUnrealisedGain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-unrealised-gain-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Unrealised Gain</h3>
      </div>
      <div class="panel-body">
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
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Realised Gain</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-4">
                <?= $form->field($model, 're_usd')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-4">
              <?= $form->field($model, 're_sgd')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-4">
              <?= $form->field($model, 're_gain_loss')->textInput(['maxlength' => true]) ?>
          </div>
        </div>
      </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
