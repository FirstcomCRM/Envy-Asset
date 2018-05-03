<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\Forex;
/* @var $this yii\web\View */
/* @var $model common\models\Stocks */
/* @var $form yii\widgets\ActiveForm */

$data = Forex::find()->select(['id','currency_code'])->all();
$forex =ArrayHelper::map($data,'id','currency_code');

?>

<div class="stocks-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'stock')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'date')->widget(DatePicker::classname(), [
      'convertFormat'=>true,
      //'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //  'type'=>1,
      'readonly' => true,
      'pluginOptions' => [
        'autoclose'=>true,
      //  'format' => 'php:Y-m-d',
        'format'=>'php:d M Y',
      ],
    ]); ?>

    <?php echo $form->field($model, 'sold_date')->widget(DatePicker::classname(), [
      'convertFormat'=>true,
    //  'type' => DatePicker::TYPE_COMPONENT_APPEND,
    //  'type'=>1,
      'readonly' => true,
      'pluginOptions' => [
        'autoclose'=>true,
      //  'format' => 'php:Y-m-d',
        'format'=>'php:d M Y',
      ],
    ]); ?>

    <?= $form->field($model, 'sold_units')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buy_units')->textInput(['maxlength' => true]) ?>

    <div class="row">
      <div class="col-md-3">
        <?php echo $form->field($model,'forex')->dropDownList($forex); ?>
      </div>
      <div class="col-md-3">

        <?= $form->field($model, 'buy_in_price')->widget(\yii\widgets\MaskedInput::className(), [
        //  'options' => ['id' => 'another-id'],
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
      <div class="col-md-3">

        <?= $form->field($model, 'buy_in_rate')->widget(\yii\widgets\MaskedInput::className(), [
        //  'options' => ['id' => 'another-id'],
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
      <div class="col-md-3">
        <?php $form->field($model, 'buy_in_local')->textInput(['maxlength' => true, 'readOnly'=>true]) ?>
        <?= $form->field($model, 'buy_in_local')->widget(\yii\widgets\MaskedInput::className(), [
          'options' => ['readOnly'=>'true', 'class'=>'form-control'],
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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
        ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
    </div>

    <br>
    <p>asdadad</p>

    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Stock Details</h3>
        </div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                //'min' => 3, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelLine[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'month',
                    'month_curr',
                    'month_price',
                    'month_rate',
                    'unrealized_curr',
                    'unrealized_local',

                ],
            ]); ?>

            <table class="table table-bordered container-items">
              <thead>
                <th style="width:15%">Month</th>
                <th style="width:10%">Month Currency</th>
                <th style="width:10%">Month End Price</th>
                <th style="width:10%">Month End Price Rate</th>
                <th style="width:10%">Unrealized Trading Currency</th>
                <th style="width:15%">Unrealized Local(SGD)</th>
                <th style="width:5%"></th>
              </thead>
              <?php foreach ($modelLine as $i => $line): ?>
              <tr class="item">
                    <?php
                          if (! $line->isNewRecord) {
                              echo Html::activeHiddenInput($line, "[{$i}]id");
                          }
                    ?>

                    <td>
                      <?php $form->field($line, "[{$i}]month")->textInput(['maxlength' => true])->label(false) ?>
                      <?php echo  $form->field($line, "[{$i}]month")->label(false)->widget(DatePicker::classname(), [
                        'convertFormat'=>true,
                      //  'options' => ['class'=>'cust-form-control dob','placeholder'=>'Date of birth','autocomplete'=>'off','readOnly'=>true,'aria-label' => 'Date of Birth'],
                        'removeButton'=>false,
                        //'pickerButton'=>false,
                        'readonly' => true,
                        'pluginOptions' => [
                          'autoclose'=>true,
                        //  'format' => 'php:Y-m-d',
                          'format'=>'php:d M Y',
                        ],
                      ]); ?>

                    </td>

                    <td>
                      <?= $form->field($line, "[{$i}]month_curr")->dropDownList($forex)->label(false) ?>
                    </td>
                    <td>
                      <?php $form->field($line, "[{$i}]month_price")->textInput(['maxlength' => true])->label(false) ?>
                      <?= $form->field($line, "[{$i}]month_price")->widget(\yii\widgets\MaskedInput::className(), [
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
                    </td>
                    <td>
                       <?= $form->field($line, "[{$i}]month_rate")->textInput(['maxlength' => true,  'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]unrealized_curr")->textInput(['maxlength' => true, 'placeholder'=>'0.00','style'=>'text-align:right' ])->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]unrealized_local")->textInput(['maxlength' => true, 'class'=>'form-control', 'placeholder'=>'0.00','style'=>'text-align:right'])->label(false) ?>

                    </td>
                    <td>
                      <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                      <button type="button" class="remove-item btn btn-danger btn-xs" id=<?php echo 'remove-'.$i.'-r' ?> ><i class="glyphicon glyphicon-minus"></i></button>
                    </td>
                    <?php endforeach; ?>
              </tr>


            </table>


          </div>

      </div>
      <?php DynamicFormWidget::end(); ?>


    <?php ActiveForm::end(); ?>

</div>



krajee-datepicker
