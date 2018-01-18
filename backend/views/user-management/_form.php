<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use common\models\UserGroup;
use common\models\Nationality;
use common\models\Department;
use common\models\TierLevel;
use common\models\UserManagement;
/* @var $this yii\web\View */
/* @var $model common\models\UserManagement */
/* @var $form yii\widgets\ActiveForm */

$data = UserGroup::find()->select(['id','usergroup'])->where(['<>','id',9])->all();
$group = ArrayHelper::map($data,'id','usergroup');

$data = Department::find()->select(['id','department'])->all();
$dept = ArrayHelper::map($data,'id','department');

$data = TierLevel::find()->select(['id','tier_level'])->all();
$tier = ArrayHelper::map($data,'id','tier_level');

$data= Nationality::find()->select(['id','nationality'])->all();
$nation = ArrayHelper::map($data, 'id','nationality');


$user_tier = UserManagement::find()->where(['id'=>$model->connect_to])->one();
if (empty($user_tier)) {
  $x = [];
}else{
  $x = [$user_tier->id => $user_tier->name];
}
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
        <?php $form->field($model, 'nationality')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model,'nationality')->widget(Select2::className(),[
            'data'=>$nation,
            'options'=>['placeholder'=>' '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>



          <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
        <?= $form->field($model, 'mobile')->textInput() ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, "apply_tier")->checkbox(['id'=>'apply_tier']); ?>
        <div id="tier-form">
          <?php echo  $form->field($model,'tier_level')->widget(Select2::className(),[
              'data'=>$tier,
              'options'=>['placeholder'=>' ','id'=>'cat-id',
              'onchange' => '
                      $.post("index.php?r=user-management/lists&id=' . '"+$(this).val(),function(data){
                        $("select#subcat-id").html(data);
                      });'
              ],
              'theme'=> Select2::THEME_BOOTSTRAP,
              'size'=> Select2::MEDIUM,
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]) ?>

            <?php
             $form->field($model, 'tier_level')->dropDownList($tier,
              ['prompt'=>'-Tier Level-',
              'onchange' => '
                      $.post("index.php?r=user-management/lists&id=' . '"+$(this).val(),function(data){
                        $("select#subcat-id").html(data);
                      });']) ?>


            <?php echo $form->field($model,'connect_to')->widget(Select2::className(),[
                //'data'=>[$user_tier->id => $user_tier->name],
                'data'=>$x,
                'options'=>['placeholder'=>' ', 'id'=>'subcat-id'],
                'theme'=> Select2::THEME_BOOTSTRAP,
                'size'=> Select2::MEDIUM,
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]) ?>


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
