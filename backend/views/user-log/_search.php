<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use common\models\User;
use common\models\TblAuditTrail;

/* @var $this yii\web\View */
/* @var $model common\models\TblAuditTrailSearch */
/* @var $form yii\widgets\ActiveForm */

$data = TblAuditTrail::find()->select(['model'])->all();
$models = ArrayHelper::map($data,'model','model');
asort($models);

$data = User::find()->select(['id','username'])->all();
$users = ArrayHelper::map($data,'id','username');
asort($users);

$actions  = [
  'DELETE'=>'DELETE',
  'CREATE'=>'CREATE',
  'SET'=>'SET',
  'CHANGE'=>'CHANGE',
];
asort($actions);

$data = null;
?>

<div class="tbl-audit-trail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model,'user_id')->label(false)->widget(Select2::className(),[
             'data'=>$users,
             'options'=>['placeholder'=>'users '],
             'theme'=> Select2::THEME_BOOTSTRAP,
             'size'=> Select2::MEDIUM,
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'model')->label(false)->widget(Select2::className(),[
             'data'=>$models,
             'options'=>['placeholder'=>'Model '],
             'theme'=> Select2::THEME_BOOTSTRAP,
             'size'=> Select2::MEDIUM,
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'action')->label(false)->widget(Select2::className(),[
             'data'=>$actions,
             'options'=>['placeholder'=>'Action '],
             'theme'=> Select2::THEME_BOOTSTRAP,
             'size'=> Select2::MEDIUM,
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'stamp')->label(false)->widget(DateRangePicker::classname(), [
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
            'placeholder'=>'Date',
            'class'=>'form-control'
          ],

        ]); ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
