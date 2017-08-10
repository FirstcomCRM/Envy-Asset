<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\ProductCategory;
use common\models\ProductType;
use common\models\ProductManagement;

/* @var $this yii\web\View */
/* @var $model common\models\ProductManagementSearch */
/* @var $form yii\widgets\ActiveForm */

$data = ProductManagement::find()->select(['product_name','product_code'])->orderBy(['product_name'=>SORT_ASC,'product_code'=>SORT_ASC])->all();
$product_name = ArrayHelper::map($data,'product_name','product_name');
$product_code = ArrayHelper::map($data,'product_code','product_code');

$data = ProductCategory::find()->select(['category'])->orderBy(['category'=>SORT_ASC])->all();
$cat = ArrayHelper::map($data,'category','category');

$data = ProductType::find()->select(['type'])->orderBy(['type'=>SORT_ASC])->all();
$type = ArrayHelper::map($data,'type','type');

$data = null;


?>

<div class="product-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
      //  'type' => ActiveForm::TYPE_INLINE,
      //  'formConfig'=>['showLabel'=>false],
    ]); ?>

    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model,'product_name')->label(false)->widget(Select2::className(),[
            'data'=>$product_name,
            'options'=>['placeholder'=>'Name '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'product_code')->label(false)->widget(Select2::className(),[
            'data'=>$product_code,
            'options'=>['placeholder'=>'Code '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'product_type')->label(false)->widget(Select2::className(),[
            'data'=>$type,
            'options'=>['placeholder'=>'Type '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
      <div class="col-md-3">

        <?php echo $form->field($model,'product_cat')->label(false)->widget(Select2::className(),[
            'data'=>$cat,
            'options'=>['placeholder'=>'Category '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
