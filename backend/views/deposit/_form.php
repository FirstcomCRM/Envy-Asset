<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use common\models\Investor;
use common\models\ProductCategory;
/* @var $this yii\web\View */
/* @var $model common\models\Deposit */
/* @var $form yii\widgets\ActiveForm */

$data = Investor::find()->orderBy(['company_name'=>SORT_ASC])->all();
$invest = ArrayHelper::map($data,'id','company_name');

$data = ProductCategory::find()->orderBy(['category'=>SORT_ASC])->all();
$cat = ArrayHelper::map($data,'id','category');

$data = null;
?>

<div class="deposit-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-6">
        <?php echo $form->field($model,'investor')->widget(Select2::className(),[
           'data'=>$invest,
           'options'=>['placeholder'=>'Select '],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>

        <?php echo $form->field($model,'category')->widget(Select2::className(),[
           'data'=>$cat,
           'options'=>['placeholder'=>'Select '],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
          'convertFormat'=>true,
          'type' => DatePicker::TYPE_COMPONENT_APPEND,
        //  'type'=>1,
          'readonly' => true,
          'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'php:Y-m-d',
          ],
        ]); ?>
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
