<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\UserManagement;
use common\models\ProductManagement;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Purchase */
/* @var $form yii\widgets\ActiveForm */

$data = UserManagement::find()->orderBy(['name'=>SORT_ASC])->select(['id','name'])->all();
$staff = ArrayHelper::map($data,'id','name');

$data = ProductManagement::find()->orderBy(['product_name'=>SORT_ASC])->select(['id','product_name'])->all();
$prod = ArrayHelper::map($data,'id','product_name');

$data = UserManagement::find()->orderBy(['name'=>SORT_ASC])->select(['id','name'])->where(['apply_tier'=>1])->all();
$users = ArrayHelper::map($data,'id','name');

$pur_type = [
  'Metal'=>'Metal',
  'Nickel'=>'Nickel',
];

$ch_type = [
  'Tier'=>'Tier',
  'Others'=>'Others',
];


$data = null;

/*$salesperson = Usermanagement::find()->where(['id'=>$model->salesperson])->one();
if (empty($salesperson)) {
    $x = [];
}else{
  $x = [$salesperson->id => $salesperson->name];
}*/

?>

<div class="purchase-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-6">

        <?php echo $form->field($model,'staff')->widget(Select2::className(),[
           'data'=>$staff,
           'options'=>['placeholder'=>'Staff'],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>

         <?php // $form->field($model, 'salesperson')->textInput(['readOnly'=>true, 'id'=>'salesperson']) ?>

         <?php echo $form->field($model, 'salesperson')->dropDownList($users,['id'=>'salesperson']) ?>

         <?php echo $form->field($model,'product')->widget(Select2::className(),[
            'data'=>$prod,
            'options'=>['placeholder'=>'Product '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>

        <?= $form->field($model, 'share')->textInput(['maxlength' => true ]) ?>
        <?= $form->field($model, 'price')->textInput(['maxlength' => true,'id'=>'s_price']) ?>

        <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
        'options' => ['id' => 's_purchase_date'],
        //  'value' => '08/10/2004',
          'convertFormat'=>true,
          'readonly' => true,
          'pluginOptions' => [
            'autoclose'=>true,
          //  'format' => 'mm/dd/yyyy'
            'format' => 'php:d M Y',
          ]
        ]); ?>
        <?php echo $form->field($model, 'expiry_date')->widget(DatePicker::classname(), [
          //'options' => ['placeholder' => 'Date'],
            'options' => ['id' => 's_expiry_date'],
        //  'value' => '08/10/2004',
          'convertFormat'=>true,
          'readonly' => true,
          'pluginOptions' => [
            'autoclose'=>true,
          //  'format' => 'mm/dd/yyyy'
            'format' => 'php:d M Y',
          ]
        ]); ?>

      </div>
      <div class="col-md-6">



        <?= $form->field($model, 'remarks')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'sum_all')->textInput(['id'=>'s_sum_all','readOnly'=>true]) ?>
        <?php echo $form->field($model, 'trading_days') ?>
        <?php echo $form->field($model, 'prorated_days') ?>
        <?php echo $form->field($model, 'purchase_type')->radioList($pur_type,['id'=>'purchase_type', 'class'=>'purchase_type']); ?>


        <?php echo  $form->field($model, 'charge_type')->dropDownList($ch_type,['id'=>'s_charge_type'])?>
        <?php echo $form->field($model, 'company_charge')->textInput(['id'=>'s_company_charge']) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
            ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
        </div>

      </div>
    </div>





    <?php ActiveForm::end(); ?>

</div>
