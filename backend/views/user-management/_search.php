<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\Department;
use common\models\UserManagement;
/* @var $this yii\web\View */
/* @var $model common\models\UserManagementSearch */
/* @var $form yii\widgets\ActiveForm */
$data = UserGroup::find()->select(['id','usergroup'])->where(['<>','id',9])->all();
$group = ArrayHelper::map($data,'usergroup','usergroup');

$data = Department::find()->select(['id','department'])->all();
$dept = ArrayHelper::map($data,'id','department');

$data = UserManagement::find()->select(['id','name','login_id'])->all();
$name = ArrayHelper::map($data,'id','name');
$login_id = ArrayHelper::map($data,'id','login_id');

$data = null;
?>

<div class="user-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model,'name')->label(false)->widget(Select2::className(),[
            'data'=>$name,
            'options'=>['placeholder'=>'Name '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'user_group')->label(false)->widget(Select2::className(),[
            'data'=>$group,
            'options'=>['placeholder'=>'User Group'],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'department')->label(false)->widget(Select2::className(),[
            'data'=>$dept,
            'options'=>['placeholder'=>'Department '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'login_id')->label(false)->widget(Select2::className(),[
            'data'=>$login_id,
            'options'=>['placeholder'=>'User Name '],
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
