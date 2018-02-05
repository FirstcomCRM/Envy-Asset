<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\ImportMetal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="import-metal-form">

    <?php $form = ActiveForm::begin(); ?>

      <div class="row">
        <div class="col-md-4">
          <?= $form->field($model, 'date_file')->widget(DatePicker::classname(), [
                        //  'options' => ['placeholder' => Yii::t('app', 'Starting Date')],
                        //  'attribute2'=>'to_date',

                          //'type' => DatePicker::TYPE_INPUT,
                          'type'=>3,
                          'pluginOptions' => [
                              'autoclose' => true,
                              'startView'=>'year',
                              'minViewMode'=>'months',
                              //'format' => 'mm-yyyy-dd'
                            //  'format' => 'yyyy-mm-dd',
                              'format' => 'dd M yyyy',
                            //    'format' => 'php:d M Y',
                          ]
                      ]) ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'remarks')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'file')->fileInput(['accept'=>'.xlsx, .xls']) ?>
        </div>
      </div>

      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
          ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
      </div>

    <?php ActiveForm::end(); ?>

</div>
