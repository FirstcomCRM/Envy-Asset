<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\ProductCategory;
use common\models\ProductType;
//use yii\widgets\ActiveForm;
//use kartik\widget\Activeform;

/* @var $this yii\web\View */
/* @var $model common\models\ProductManagement */
/* @var $form yii\widgets\ActiveForm */


$data = ProductCategory::find()->select(['category'])->orderBy(['category'=>SORT_ASC])->all();
$cat = ArrayHelper::map($data,'category','category');

$data = ProductType::find()->select(['type'])->orderBy(['type'=>SORT_ASC])->all();
$type = ArrayHelper::map($data,'type','type');
?>

<div class="product-management-form">

    <?php $form = ActiveForm::begin([
      //'id'=>'test',
      'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>
    <div class="row">
      <div class="col-md-6">

        <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

      </div>
      <div class="col-md-6">
        <?php echo $form->field($model,'product_type')->widget(Select2::className(),[
            'data'=>$type,
            'options'=>['placeholder'=>'Type '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
        <?php echo $form->field($model,'product_cat')->widget(Select2::className(),[
            'data'=>$cat,
            'options'=>['placeholder'=>'Category '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>

        <?= $form->field($model, 'product_price')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'product_cost')->textInput(['maxlength' => true]) ?>

        <div class="row">
          <div class="col-md-offset-1">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
            </div>
          </div>
        </div>

      </div>

    </div>





    <?php ActiveForm::end(); ?>

</div>
