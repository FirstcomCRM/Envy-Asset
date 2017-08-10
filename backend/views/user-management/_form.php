<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\Department;
/* @var $this yii\web\View */
/* @var $model common\models\UserManagement */
/* @var $form yii\widgets\ActiveForm */

$data = UserGroup::find()->select(['usergroup'])->all();
$group = ArrayHelper::map($data,'usergroup','usergroup');

$data = Department::find()->select(['department'])->all();
$dept = ArrayHelper::map($data,'department','department');

$data = null;
?>

<div class="user-management-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-4">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model,'user_group')->widget(Select2::className(),[
            'data'=>$group,
            'options'=>['placeholder'=>' '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>

          <?php echo $form->field($model,'department')->widget(Select2::className(),[
              'data'=>$dept,
              'options'=>['placeholder'=>' '],
              'theme'=> Select2::THEME_BOOTSTRAP,
              'size'=> Select2::MEDIUM,
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'nationality')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'mobile')->textInput() ?>
        <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'login_id')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'login_password')->passwordInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
            ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
        </div>
      </div>
    </div>







    <?php ActiveForm::end(); ?>

</div>
