<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use kartik\daterange\DateRangePicker;
use yii\jui\DatePicker;
use common\models\Investor;
/* @var $this yii\web\View */
/* @var $model common\models\PurchaseSearch */
/* @var $form yii\widgets\ActiveForm */

$data = Investor::find()->select(['id','company_name'])->orderBy(['company_name'=>SORT_ASC])->all();
$investors = ArrayHelper::map($data,'id','company_name');

?>
<style>
.ui-datepicker table{
    display: none;
}
</style>

<div class="alter-search">

  <?php $form = ActiveForm::begin([
      'action' => ['alter'],
      'method' => 'get',
  ]); ?>

  <div class="row">
    <div class="col-md-3">
      <?php echo $form->field($model,'date_filter')->label(false)->widget(yii\jui\DatePicker::className(), [
        'options'=>['class'=>'form-control  monthPicker','readOnly'=>true,'placeholder'=>'Select Date'],
        'dateFormat'=>'php:M Y',
        'clientOptions'=>[
          'changeMonth' => true,
          'changeYear' => true,
          'showButtonPanel'=> true,
        ],
        ]) ?>
    </div>

    <div class="col-md-3">
      <?php echo $form->field($model,'id')->label(false)->dropDownList($investors,['prompt'=>'Select Investor']) ?>
    </div>


    <div class="col-md-3">
      <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>

      <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['alter'],['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?php ActiveForm::end(); ?>


</div>
