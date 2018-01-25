<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $model common\models\MetalNiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metal-ni-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

      <div class="row">
        <div class="col-md-4">
          <?php echo $form->field($model,'date_filter')->label(false)->widget(DateRangePicker::classname(), [
            'useWithAddon'=>false,
            'convertFormat'=>true,
            'pluginOptions'=>[
              'locale'=>[
                'format'=> 'd M Y',
              ],
            ],
            'options'=>[
              'placeholder'=>'Date',
              'class'=>'form-control'
            ],
          ]); ?>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
             <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
          </div>
        </div>
        <div class="col-md-4">

        </div>
      </div>

    <?php ActiveForm::end(); ?>

</div>
