<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\InvestorGroup;
use common\models\UserManagement;
use common\models\UserGroup;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
$data = InvestorGroup::find()->select(['customer_group'])->all();
$cgroup = ArrayHelper::map($data,'customer_group','customer_group');

$data = UserManagement::find()->where(['apply_tier'=>1])->orderBy(['id'=>SORT_ASC])->all();
$sales = ArrayHelper::map($data,'id','name');

//$data = UserGroup::find()->select(['id','usergroup'])->all();
//$group = ArrayHelper::map($data,'id','usergroup');

$group = [
  9=>'Investor',
];

$data = null;

?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Investor Details</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-3">
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model,'salesperson')->widget(Select2::className(),[
               'data'=>$sales,
               'options'=>['placeholder'=>''],
               'theme'=> Select2::THEME_BOOTSTRAP,
               'size'=> Select2::MEDIUM,
               'pluginOptions' => [
                 'allowClear' => true
               ],
             ]) ?>
             <?= $form->field($model, 'company_registration')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'nric')->textInput(['maxlength' => true]) ?>
              <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
              <?php echo $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                //'options' => ['placeholder' => 'Date'],
                'convertFormat'=>true,
                'readonly' => true,
                'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'php:d M Y',
                ]
              ]); ?>
          </div>
          <div class="col-md-3">
            <?php echo $form->field($model,'customer_group')->widget(Select2::className(),[
               'data'=>$cgroup,
               'options'=>['placeholder'=>''],
               'theme'=> Select2::THEME_BOOTSTRAP,
               'size'=> Select2::MEDIUM,
               'pluginOptions' => [
                 'allowClear' => true
               ],
             ]) ?>
               <?= $form->field($model, 'mobile')->textInput() ?>
               <?= $form->field($model, 'email_cc')->textarea(['rows' => 3]) ?>
          </div>
          <div class="col-md-3">
            <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'passport_no')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'remark')->textarea(['rows' => 3]) ?>

          </div>

        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title">Bank Accounts</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-3">
              <?= $form->field($model, 'bank_a')->textarea(['rows' => 4]) ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'bank_b')->textarea(['rows' => 4]) ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'bank_c')->textarea(['rows' => 4]) ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'bank_d')->textarea(['rows' => 4]) ?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'bank_e')->textarea(['rows' => 4]) ?>
          </div>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Login Details</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-4">
            <?= $form->field($model, 'username')->textInput() ?>
          </div>
          <div class="col-md-4">
            <?= $form->field($model, 'password')->passwordInput() ?>
          </div>
          <div class="col-md-4">
            <?php echo $form->field($model,'usergroup')->widget(Select2::className(),[
                'data'=>$group,
              //  'options'=>['placeholder'=>' '],
                'theme'=> Select2::THEME_BOOTSTRAP,
                'size'=> Select2::MEDIUM,
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]) ?>
          </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
            ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
        </div>
      </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
