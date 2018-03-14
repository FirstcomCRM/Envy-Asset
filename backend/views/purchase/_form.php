<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Investor;
use common\models\ProductManagement;
use common\models\UserManagement;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Purchase */
/* @var $form yii\widgets\ActiveForm */

$data = Investor::find()->orderBy(['company_name'=>SORT_ASC])->select(['id','nric_comp'])->all();
$invest = ArrayHelper::map($data,'id','nric_comp');

$data = ProductManagement::find()->orderBy(['product_name'=>SORT_ASC])->select(['id','product_name'])->all();
$prod = ArrayHelper::map($data,'id','product_name');

$pur_type = [
  'Metal'=>'Metal',
  'Nickel'=>'Nickel',
];

$ch_type = [
  'Tier'=>'Tier',
  'Others'=>'Others',
];

$data = null;

$salesperson = Usermanagement::find()->where(['id'=>$model->salesperson])->one();
if (empty($salesperson)) {
    $x = [];
}else{
  $x = [$salesperson->id => $salesperson->name];
}

?>

<div class="purchase-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-6">

        <?php echo $form->field($model,'investor')->widget(Select2::className(),[
           'data'=>$invest,
           'options'=>['placeholder'=>'Investor',
            'onchange'=>'$.post("'.url::to(['purchase/get-sales','id'=>'']).
              '"+$(this).val(),function( data )
                {
                  $("#salesperson").html( data );
                });'

            ],
           'theme'=> Select2::THEME_BOOTSTRAP,
           'size'=> Select2::MEDIUM,
           'pluginOptions' => [
             'allowClear' => true
           ],
         ]) ?>

         <?php // $form->field($model, 'salesperson')->textInput(['readOnly'=>true, 'id'=>'salesperson']) ?>

         <?php echo $form->field($model, 'salesperson')->dropDownList($x,['id'=>'salesperson']) ?>

         <?php echo $form->field($model,'product')->widget(Select2::className(),[
            'data'=>$prod,
            'options'=>['placeholder'=>'Product '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>

        <?= $form->field($model, 'share')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'price')->textInput(['maxlength' => true,'id'=>'price']) ?>

        <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
          'options' => ['id' => 'purchase_date'],
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
            'options' => ['id' => 'expiry_date'],
        //  'value' => '08/10/2004',
          'convertFormat'=>true,
          'readonly' => true,
          'pluginOptions' => [
            'autoclose'=>true,
          //  'format' => 'mm/dd/yyyy'
            'format' => 'php:d M Y',
          ]
        ]); ?>
        <?= $form->field($model, 'remarks')->textarea(['rows' => 4]) ?>


      </div>

      <div class="col-md-6">

        <?= $form->field($model, 'sum_all')->textInput(['id'=>'sum_all','readOnly'=>true]) ?>
        <?php echo $form->field($model, 'trading_days') ?>
        <?php echo $form->field($model, 'prorated_days') ?>
        <?php echo $form->field($model, 'purchase_type')->radioList($pur_type,['id'=>'purchase_type', 'class'=>'purchase_type']); ?>
        <?php echo  $form->field($model, 'charge_type')->dropDownList($ch_type,['id'=>'charge_type'])?>
        <?php echo $form->field($model, 'company_charge')->textInput(['id'=>'company_charge']) ?>

        <?php echo $form->field($model, 'customer_earn')->textInput(['id'=>'customer_earn', 'readOnly'=>true]) ?>
        <?php echo $form->field($model, 'company_earn')->textInput(['id'=>'company_earn', 'readOnly'=>true]) ?>
        <?php echo $form->field($model, 'staff_earn')->textInput(['id'=>'staff_earn', 'readOnly'=>true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
            ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
        </div>
      </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>


<div class="" id="result">

</div>
