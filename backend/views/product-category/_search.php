<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use common\models\ProductCategory;
/* @var $this yii\web\View */
/* @var $model common\models\ProductCategorySearch */
/* @var $form yii\widgets\ActiveForm */

$data = ProductCategory::find()->select(['category'])->orderBy(['category'=>SORT_ASC])->all();
$cat = ArrayHelper::map($data,'category','category');
?>

<div class="product-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
      <div class="col-md-4">
        <?php echo $form->field($model,'category')->label(false)->widget(Select2::className(),[
                'data'=>$cat,
                'options'=>['placeholder'=>'Category '],
                'theme'=> Select2::THEME_BOOTSTRAP,
                'size'=> Select2::MEDIUM,
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]) ?>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
          <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class'=>'btn btn-default']) ?>
        </div>
      </div>
      <div class="col-md-4">
        <!---Excess-->
      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
