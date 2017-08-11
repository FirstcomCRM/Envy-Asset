<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\CustomerGroup;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
$data = CustomerGroup::find()->select(['customer_group'])->all();
$cgroup = ArrayHelper::map($data,'customer_group','customer_group');

$data = null;

?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($model,'customer_group')->widget(Select2::className(),[
           'data'=>$cgroup,
           'options'=>['placeholder'=>'Customer Group '],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>
        <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'mobile')->textInput() ?>
      </div>

      <div class="col-md-6">
        <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'remark')->textarea(['rows' => 4]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
            ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
        </div>
      </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>