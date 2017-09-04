<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use common\models\UserGroup;
use common\models\Department;
use common\models\TierLevel;
use common\models\UserManagement;
/* @var $this yii\web\View */
/* @var $model common\models\UserManagement */
/* @var $form yii\widgets\ActiveForm */

$data = UserGroup::find()->select(['usergroup'])->all();
$group = ArrayHelper::map($data,'usergroup','usergroup');

$data = Department::find()->select(['department'])->all();
$dept = ArrayHelper::map($data,'department','department');

$data = TierLevel::find()->select(['id','tier_level'])->all();
$tier = ArrayHelper::map($data,'id','tier_level');

$user_tier = UserManagement::find()->where(['id'=>$model->connect_to])->one();
//$user_tier = ArrayHelper::map($data,'id','id');

//print_r($data);
//die();

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
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'mobile')->textInput() ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, "apply_tier")->checkbox(['id'=>'apply_tier']); ?>
        <div id="tier-form">
          <?php echo $form->field($model,'tier_level')->widget(Select2::className(),[
              'data'=>$tier,
              'options'=>['placeholder'=>' ','id'=>'cat-id'],
              'theme'=> Select2::THEME_BOOTSTRAP,
              'size'=> Select2::MEDIUM,
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]) ?>
            <?php echo $form->field($model, "connect_to")->widget(DepDrop::className(),[
                'options'=>['id'=>'subcat-id' ,'placeholder'=>'Select...'],
                'type'=>2,
              //  'data'=>[$model->id => $model->name],
                'data'=>[$user_tier->id => $user_tier->name],
                //'data'=>[$line->complaint_id =>  $line->complaint_name],
                'select2Options'=>['pluginOptions'=>['allowClear'=>true],'size'=> Select2::MEDIUM,'theme'=> Select2::THEME_BOOTSTRAP],
                'pluginOptions'=>[
                  'depends'=>['cat-id'],
                  'placeholder'=>'Select...',
                  'url'=>Url::to(['/user-management/fetch-tier']),
                ]

              ]);  ?>
        </div>
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
