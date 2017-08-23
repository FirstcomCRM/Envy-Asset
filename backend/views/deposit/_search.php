<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use common\models\Investor;
use common\models\ProductCategory;
/* @var $this yii\web\View */
/* @var $model common\models\DepositSearch */
/* @var $form yii\widgets\ActiveForm */

$data = Investor::find()->orderBy(['company_name'=>SORT_ASC])->all();
$invest = ArrayHelper::map($data,'id','company_name');

$data = ProductCategory::find()->orderBy(['category'=>SORT_ASC])->all();
$cat = ArrayHelper::map($data,'id','category');

$data = null;
?>

<div class="deposit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model,'investor')->label(false)->widget(Select2::className(),[
           'data'=>$invest,
           'options'=>['placeholder'=>'Investor '],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'category')->label(false)->widget(Select2::className(),[
           'data'=>$cat,
           'options'=>['placeholder'=>'Product Category '],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
          <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
        </div>
      </div>
      <div class="col-md-3">
        <?php $form->field($model, 'date') ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
