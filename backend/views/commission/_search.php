<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $model common\models\CommissionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commission-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php $form->field($model, 'transact_date') ?>

    <?php echo $form->field($model, 'transact_date')->label()->widget(DateRangePicker::classname(), [
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
        'placeholder'=>'Select Date Range',
        'class'=>'form-control'
      ],
    ]);?>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
