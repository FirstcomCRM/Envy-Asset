<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Investor;
use common\models\UserManagement;
use common\models\ProductManagement;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Withdraw */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
  $data = Investor::find()->orderBy(['company_name'=>SORT_ASC])->where(['id'=>0])->select(['id','nric_comp'])->all();
  $invest = ArrayHelper::map($data,'id','nric_comp');
}else{
  if ($model->type == 'Investor') {
    $data = Investor::find()->orderBy(['company_name'=>SORT_ASC])->select(['id','nric_comp'])->all();
    $invest = ArrayHelper::map($data,'id','nric_comp');
  }else{
    $data = UserManagement::find()->orderBy(['name'=>SORT_ASC])->select(['id','name'])->all();
    $invest = ArrayHelper::map($data,'id','name');
  }
}


$data = ProductManagement::find()->orderBy(['product_name'=>SORT_ASC])->select(['id','product_name'])->all();
$prod = ArrayHelper::map($data,'id','product_name');

$type = [
  'Investor'=>'Investor',
  'Staff'=>'Staff',
];

$data = null;
?>

<div class="withdraw-form">

    <?php $form = ActiveForm::begin(); ?>
      <div class="row">
        <div class="col-md-6">
          <?php echo $form->field($model,'type')->widget(Select2::className(),[
             'data'=>$type,
             'options'=>['placeholder'=>'Select Type ', 'id'=>'withdraw-type'],
             'theme'=> Select2::THEME_BOOTSTRAP,
             'size'=> Select2::MEDIUM,
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]) ?>

          <?php echo $form->field($model,'investor')->widget(Select2::className(),[
             'data'=>$invest,
             'options'=>['placeholder'=>'Select... ', 'id'=>'withdraw-investor'],
             'theme'=> Select2::THEME_BOOTSTRAP,
             'size'=> Select2::MEDIUM,
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]) ?>
          <?php echo $form->field($model,'product')->widget(Select2::className(),[
             'data'=>$prod,
             'options'=>['placeholder'=>'Select... '],
             'theme'=> Select2::THEME_BOOTSTRAP,
             'size'=> Select2::MEDIUM,
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]) ?>

           <?= $form->field($model, 'price')->widget(\yii\widgets\MaskedInput::className(), [
             'options' => ['id' => 'price','class'=>'form-control'],
             'clientOptions' => [
               'alias' => 'decimal',
               'digits' => 2,
               'digitsOptional' => false,
               'radixPoint' => '.',
               'groupSeparator' => ',',
               'autoGroup' => true,
               'removeMaskOnSubmit' => true,
             ],
           ]) ?>

          <?php $form->field($model, 'date')->textInput() ?>
          <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
            'type'=>3,
            'convertFormat'=>true,
            'readonly' => true,
            'pluginOptions' => [
              'autoclose'=>true,
            //  'format' => 'php:Y-m-d',
                'format' => 'php:d M Y',
            ]
          ]); ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

          <div class="form-group">
              <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
              ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
          </div>
        </div>
      </div>

    <?php ActiveForm::end(); ?>

</div>
