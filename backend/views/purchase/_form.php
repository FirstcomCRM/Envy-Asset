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

$data = Investor::find()->orderBy(['company_name'=>SORT_ASC])->select(['id','company_name'])->all();
$invest = ArrayHelper::map($data,'id','company_name');

$data = ProductManagement::find()->orderBy(['product_name'=>SORT_ASC])->select(['id','product_name'])->all();
$prod = ArrayHelper::map($data,'id','product_name');

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
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-md-6">
        <?php $form->field($model, 'date')->textInput() ?>
        <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
          //'options' => ['placeholder' => 'Date'],
        //  'value' => '08/10/2004',
          'convertFormat'=>true,
          'readonly' => true,
          'pluginOptions' => [
            'autoclose'=>true,
          //  'format' => 'mm/dd/yyyy'
            'format' => 'php:Y-m-d',
          ]
        ]); ?>
        <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>
      </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
        ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
