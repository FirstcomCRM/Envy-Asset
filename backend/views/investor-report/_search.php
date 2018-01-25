<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use common\models\Investor;
use common\models\ProductManagement;
use common\models\UserManagement;
/* @var $this yii\web\View */
/* @var $model common\models\PurchaseSearch */
/* @var $form yii\widgets\ActiveForm */
$data = UserManagement::find()->select(['id','name'])->orderBy(['name'=>SORT_ASC])->where(['apply_tier'=>1])->all();
$sales = ArrayHelper::map($data,'id','name');
$data = null;
?>

<div class="purchase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model, 'date')->label(false)->widget(DateRangePicker::classname(), [
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
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'salesperson')->label(false)->widget(Select2::className(),[
            'data'=>$sales,
            'options'=>['placeholder'=>'Sales Person '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'purchase_no')->textInput(['placeholder'=>'Purchase No'])->label(false) ?>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
              <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>

          </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
