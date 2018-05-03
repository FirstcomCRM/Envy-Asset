<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\Investor;
use common\models\ProductManagement;
use common\models\UserManagement;
use common\models\Forex;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Purchase */
/* @var $form yii\widgets\ActiveForm */

$data = Investor::find()->orderBy(['company_name'=>SORT_ASC])->select(['id','nric_comp'])->all();
$invest = ArrayHelper::map($data,'id','nric_comp');

$data = ProductManagement::find()->orderBy(['product_name'=>SORT_ASC])->select(['id','product_name'])->all();
$prod = ArrayHelper::map($data,'id','product_name');

$data = Forex::find()->all();
$forex = ArrayHelper::map($data,'id','currency_code');

$pur_type = [
  'Metal'=>'Metal',
  'Nickel'=>'Nickel',
  'Stocks'=>'Stocks',
];

$ch_type = [
  'Tier'=>'Tier',
  'Others'=>'Others',
];

$data = null;

$salesperson  =UserManagement::find()->all();
$x = ArrayHelper::map($salesperson,'id','name');

?>


<div class="purchase-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
      <div class="col-md-6">

        <?php echo $form->field($model,'investor')->widget(Select2::className(),[
           'data'=>$invest,
           'options'=>['placeholder'=>'Investor',
            'onchange'=>'$.post("'.url::to(['purchase/get-sales','id'=>'']).
              '"+$(this).val(),function( data )
                {
                  $("#salesperson").html(data);
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

         <?php echo $form->field($model, 'purchase_type')->radioList($pur_type,['id'=>'purchase_type', 'class'=>'purchase_type']); ?>

         <?php echo $form->field($model,'product')->widget(Select2::className(),[
            'data'=>$prod,
            'options'=>['placeholder'=>'Product', 'id'=>'products'],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>

        <?= $form->field($model, 'share')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'price')->widget(\yii\widgets\MaskedInput::className(), [
          'options' => ['id' => 'price','class'=>'form-control'],
          'clientOptions' => [
            'alias' => 'decimal',
            'digits' => 2,
            'digitsOptional' => false,
            'radixPoint' => '.',
            'groupSeparator' => ',',
            'autoGroup' => true,
            'removeMaskOnSubmit' => true,
          ],
        ]) ?>

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


        <?php echo $form->field($model, 'trading_days')->textInput(['style'=>'text-align:right;']) ?>
        <?php echo $form->field($model, 'prorated_days')->textInput(['style'=>'text-align:right;']) ?>

        <div id="nickels-test">
          <?php echo $form->field($model, 'nickel_date')->textInput(['readOnly'=>true]) ?>
          <?php echo $form->field($model, 'nickel_expiry')->textInput(['readOnly'=>true]) ?>
        </div>
        <div id="stocks-test">
          <?php echo $form->field($model, 'sold_currency')->dropDownList($forex,['prompt'=>'Select Currency']) ?>


          <?= $form->field($model, 'sold_price')->widget(\yii\widgets\MaskedInput::className(), [
            'options' => ['class'=>'form-control'],
            'clientOptions' => [
              'alias' => 'decimal',
              'digits' => 2,
              'digitsOptional' => false,
              'radixPoint' => '.',
              'groupSeparator' => ',',
              'autoGroup' => true,
              'removeMaskOnSubmit' => true,
            ],
          ]) ?>
          <?= $form->field($model, 'sold_price_rate')->widget(\yii\widgets\MaskedInput::className(), [
            'options' => ['class'=>'form-control'],
            'clientOptions' => [
              'alias' => 'decimal',
              'digits' => 2,
              'digitsOptional' => false,
              'radixPoint' => '.',
              'groupSeparator' => ',',
              'autoGroup' => true,
              'removeMaskOnSubmit' => true,
            ],
          ]) ?>


        </div>

        <?php echo  $form->field($model, 'charge_type')->dropDownList($ch_type,['id'=>'charge_type'])?>
        <?php echo $form->field($model, 'company_charge')->textInput(['id'=>'company_charge','style'=>'text-align:right;']) ?>

        <?= $form->field($model, 'customer_earn')->widget(\yii\widgets\MaskedInput::className(), [
          'options' => ['id' => 'customer_earn','class'=>'form-control','readOnly'=>true],
          'clientOptions' => [
            'alias' => 'decimal',
            'digits' => 2,
            'digitsOptional' => false,
            'radixPoint' => '.',
            'groupSeparator' => ',',
            'autoGroup' => true,
            'removeMaskOnSubmit' => true,
          ],
        ]) ?>
        <?= $form->field($model, 'company_earn')->widget(\yii\widgets\MaskedInput::className(), [
          'options' => ['id' => 'company_earn','class'=>'form-control','readOnly'=>true],
          'clientOptions' => [
            'alias' => 'decimal',
            'digits' => 2,
            'digitsOptional' => false,
            'radixPoint' => '.',
            'groupSeparator' => ',',
            'autoGroup' => true,
            'removeMaskOnSubmit' => true,
          ],
        ]) ?>
        <?= $form->field($model, 'staff_earn')->widget(\yii\widgets\MaskedInput::className(), [
          'options' => ['id' => 'staff_earn','class'=>'form-control','readOnly'=>true],
          'clientOptions' => [
            'alias' => 'decimal',
            'digits' => 2,
            'digitsOptional' => false,
            'radixPoint' => '.',
            'groupSeparator' => ',',
            'autoGroup' => true,
            'removeMaskOnSubmit' => true,
          ],
        ]) ?>



      </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Company Sold</h3>
        </div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items_a', // required: css class selector
                'widgetItem' => '.item_a', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                //'min' => 3, // 0 or 1 (default 1)
                'insertButton' => '.add-item_a', // css class
                'deleteButton' => '.remove-item_a', // css class
                'model' => $modelLine[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'psold_date',
                    'psold_currency',
                    'pcurrency_rate',
                    'psold_price',
                    'psold_units',
                    'pbalance',

                ],
            ]); ?>

            <table class="table table-bordered container-items_a">
              <thead>
                <th style="width:15%">Sold Date</th>
                <th style="width:10%">Sold Currency</th>
                <th style="width:10%">Currency Rate</th>
                <th style="width:10%">Sold Price</th>
                <th style="width:10%">Sold Units</th>
                <th style="width:15%">Balance</th>
                <th style="width:5%"></th>
              </thead>
              <?php foreach ($modelLine as $i => $line): ?>
              <tr class="item_a">
                    <?php
                          if (! $line->isNewRecord) {
                              echo Html::activeHiddenInput($line, "[{$i}]id");
                          }
                    ?>

                    <td>
                      <?= $form->field($line, "[{$i}]psold_date")->textInput(['maxlength' => true])->label(false) ?>
                    </td>

                    <td>
                      <?= $form->field($line, "[{$i}]psold_currency")->dropDownList($forex)->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]pcurrency_rate")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                        'options' => ['class'=>'form-control'],
                        'clientOptions' => [
                          'alias' => 'decimal',
                          'digits' => 4,
                          'digitsOptional' => false,
                          'radixPoint' => '.',
                          'groupSeparator' => ',',
                          'autoGroup' => true,
                          'removeMaskOnSubmit' => true,
                        ],
                      ]) ?>
                    </td>
                    <td>

                       <?= $form->field($line, "[{$i}]psold_price")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                         'options' => ['class'=>'form-control','onchange'=>'pursolds($(this))'],
                         'clientOptions' => [
                           'alias' => 'decimal',
                           'digits' => 2,
                           'digitsOptional' => false,
                           'radixPoint' => '.',
                           'groupSeparator' => ',',
                           'autoGroup' => true,
                           'removeMaskOnSubmit' => true,
                         ],
                       ]) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]psold_units")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                        'options' => ['class'=>'form-control','onchange'=>'pursolds($(this))'],
                        'clientOptions' => [
                          'alias' => 'decimal',
                          'digits' => 2,
                          'digitsOptional' => false,
                          'radixPoint' => '.',
                          'groupSeparator' => ',',
                          'autoGroup' => true,
                          'removeMaskOnSubmit' => true,
                        ],
                      ]) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]pbalance")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                        'options' => ['class'=>'form-control', 'readOnly'=>true],
                        'clientOptions' => [
                          'alias' => 'decimal',
                          'digits' => 2,
                          'digitsOptional' => false,
                          'radixPoint' => '.',
                          'groupSeparator' => ',',
                          'autoGroup' => true,
                          'removeMaskOnSubmit' => true,
                        ],
                      ]) ?>
                    </td>
                    <td>
                      <button type="button" class="add-item_a btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                      <button type="button" class="remove-item_a btn btn-danger btn-xs" id=<?php echo 'remove-'.$i.'-ra' ?> ><i class="glyphicon glyphicon-minus"></i></button>
                    </td>
                    <?php endforeach; ?>
              </tr>


            </table>

            <?php DynamicFormWidget::end(); ?>
          </div>

      </div>

      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
          ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
      </div>

    <?php ActiveForm::end(); ?>

</div>


<div class="" id="result">

</div>
