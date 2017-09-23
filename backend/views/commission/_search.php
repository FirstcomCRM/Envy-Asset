<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use common\models\UserManagement;
/* @var $this yii\web\View */
/* @var $model common\models\CommissionSearch */
/* @var $form yii\widgets\ActiveForm */

$data = UserManagement::find()->select(['id','name'])->orderBy(['name'=>SORT_ASC])->where(['apply_tier'=>1])->all();
$sales = ArrayHelper::map($data,'id','name');
?>

<div class="commission-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model, 'transact_date')->label(false)->widget(DateRangePicker::classname(), [
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
            'placeholder'=>'Transaction Date Range',
            'class'=>'form-control'
          ],
        ]);?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'sales_person')->label(false)->widget(Select2::className(),[
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
        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
            <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
        </div>
      </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
