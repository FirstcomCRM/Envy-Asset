<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Spinner;
//use kartik\daterange\DateRangePicker;
use yii\jui\DatePicker;
use kartik\widgets\Select2;
use common\models\Investor;
/* @var $this yii\web\View */
/* @var $model common\models\PurchaseSearch */
/* @var $form yii\widgets\ActiveForm */

$data = Investor::find()->select(['id','company_name'])->orderBy(['company_name'=>SORT_ASC])->all();
$investors = ArrayHelper::map($data,'id','company_name');
$test = Spinner::widget(['preset' => 'large', 'align' => 'center']);
?>
<style>
.ui-datepicker table{
    display: none;
}

</style>

<div class="overlay">
    <div id="loading-img"></div>
</div>

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
      <?php echo $form->field($model,'id')->label(false)->widget(Select2::className(),[
        'data'=>$investors,
        'options'=>['placeholder'=>'Investor '],
        'theme'=> Select2::THEME_BOOTSTRAP,
        'size'=> Select2::MEDIUM,
        'pluginOptions' => [
          'allowClear' => true
        ],
      ]) ?>
    </div>


    <div class="col-md-4">
      <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
      <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['alter'],['class' => 'btn btn-default']) ?>
      <?php echo Html::a('<i class="fa fa-print" aria-hidden="true"></i> Email Button A',['alter-email'],['class' => 'btn btn-default','id'=>'multi-email']) ?>


    </div>
  </div>

  <?php ActiveForm::end(); ?>


</div>
