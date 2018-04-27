<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\widgets\DatePicker;
use yii\jui\DatePicker;
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



    <?php echo $form->field($model, 'stock')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model,'date')->widget(yii\jui\DatePicker::className(), [
      'options'=>['class'=>'form-control'],
      ]) ?>

    <?= $form->field($model, 'ticker')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exchange')->textInput(['maxlength' => true]) ?>

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



    <br>

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
                <th style="width:10%">Unrealized Gain/Loss</th>
                <th style="width:15%">Unrealized Gain/Loss (%)</th>
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
                      <?php echo $form->field($line,"[{$i}]month")->label(false)->widget(yii\jui\DatePicker::className(),
                      ['options' => ['class' => 'form-control picker'], 'dateFormat'=>'php:Y-m-d'] )
                      ?>
                    </td>

                    <td>
                      <?= $form->field($line, "[{$i}]month_curr")->dropDownList($forex)->label(false) ?>
                    </td>
                    <td>
                      <?= $form->field($line, "[{$i}]month_price")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                        'options' => ['class'=>'form-control', 'onchange'=>'lineCurr($(this))'],
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

                       <?= $form->field($line, "[{$i}]month_rate")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                         'options' => ['class'=>'form-control','onchange'=>'lineCurr($(this))'],
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
                      <?= $form->field($line, "[{$i}]unrealized_curr")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                        'options' => ['class'=>'form-control urcurr','readOnly'=>true],
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
                      <?= $form->field($line, "[{$i}]unrealized_local")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                        'options' => ['class'=>'form-control urlocal', 'readOnly'=>true],
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
                      <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                      <button type="button" class="remove-item btn btn-danger btn-xs" id=<?php echo 'remove-'.$i.'-r' ?> ><i class="glyphicon glyphicon-minus"></i></button>
                    </td>
                    <?php endforeach; ?>
              </tr>


            </table>


          </div>

      </div>
      <?php DynamicFormWidget::end(); ?>

      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil" aria-hidden="true"></i> Create' : '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update',
          ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-default']) ?>
      </div>

    <?php ActiveForm::end(); ?>

</div>
