<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\CustomerGroup;
use common\models\Customer;
/* @var $this yii\web\View */
/* @var $model common\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
$data = CustomerGroup::find()->select(['customer_group'])->all();
$cgroup = ArrayHelper::map($data,'customer_group','customer_group');

$data = Customer::find()->select(['company_name'])->all();
$company = ArrayHelper::map($data,'company_name','company_name');

$data = null;

?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model,'company_name')->label(false)->widget(Select2::className(),[
           'data'=>$company,
           'options'=>['placeholder'=>'Customer '],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model,'customer_group')->label(false)->widget(Select2::className(),[
           'data'=>$cgroup,
           'options'=>['placeholder'=>'Customer Group '],
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
