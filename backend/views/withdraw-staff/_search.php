<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use common\models\UserManagement;
use common\models\ProductManagement;

/* @var $this yii\web\View */
/* @var $model common\models\WithdrawSearch */
/* @var $form yii\widgets\ActiveForm */
$data = UserManagement::find()->orderBy(['name'=>SORT_ASC])->select(['id','name'])->all();
$staff = ArrayHelper::map($data,'id','name');

$data = ProductManagement::find()->orderBy(['product_name'=>SORT_ASC])->select(['id','product_name'])->all();
$prod = ArrayHelper::map($data,'id','product_name');

$data = null;
?>

<div class="withdraw-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

      <div class="row">
        <div class="col-md-3">
          <?php echo $form->field($model,'staff')->label(false)->widget(Select2::className(),[
             'data'=>$staff,
             'options'=>['placeholder'=>'Staf '],
             'theme'=> Select2::THEME_BOOTSTRAP,
             'size'=> Select2::MEDIUM,
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]) ?>
        </div>
        <div class="col-md-3">
          <?php echo $form->field($model,'product')->label(false)->widget(Select2::className(),[
             'data'=>$prod,
             'options'=>['placeholder'=>'Product '],
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
