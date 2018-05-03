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

    <?php if (!$model->isNewRecord ): ?>
      <?= $form->field($model, 'balance_unit')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>


    <?= $form->field($model, 'buy_units')->widget(\yii\widgets\MaskedInput::className(), [
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

      <br>

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
                  'model' => $modelLinea[0],
                  'formId' => 'dynamic-form',
                  'formFields' => [
                      'sold_date',
                      'sold_currency',
                      'currency_rate',
                      'sold_price',
                      'sold_units',
                      'balance',

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
                <?php foreach ($modelLinea as $i => $line): ?>
                <tr class="item_a">
                      <?php
                            if (! $line->isNewRecord) {
                                echo Html::activeHiddenInput($line, "[{$i}]id");
                            }
                      ?>

                      <td>
                        <?php echo $form->field($line,"[{$i}]sold_date")->label(false)->widget(yii\jui\DatePicker::className(),
                        ['options' => ['class' => 'form-control picker'], 'dateFormat'=>'php:Y-m-d'] )
                        ?>
                      </td>

                      <td>
                        <?= $form->field($line, "[{$i}]sold_currency")->dropDownList($forex)->label(false) ?>
                      </td>
                      <td>
                        <?= $form->field($line, "[{$i}]currency_rate")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
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

                         <?= $form->field($line, "[{$i}]sold_price")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                           'options' => ['class'=>'form-control','onchange'=>'solds($(this))'],
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
                        <?= $form->field($line, "[{$i}]sold_units")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                          'options' => ['class'=>'form-control sumPart','onchange'=>'solds($(this))'],
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
                        <?= $form->field($line, "[{$i}]balance")->label(false)->widget(\yii\widgets\MaskedInput::className(), [
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
                        <button type="button" class="remove-item_a btn btn-danger btn-xs" id=<?php echo 'remove-'.$i.'-ra' ?> onclick="offRecalc($(this))"><i class="glyphicon glyphicon-minus"></i></button>
                      </td>
                      <?php endforeach; ?>
                </tr>


              </table>

              <!----->

              <table class="table">
                <tr>
                  <td style="width:15%;border-top:0px"></td>
                  <td style="width:10%;border-top:0px"></td>
                  <td style="width:10%;border-top:0px"></td>
                  <td style="width:10%;border-top:0px;vertical-align:middle; text-align:right;border-top:0px" ><label>Total Sold Units</label></td>
                  <td style="width:10%;vertical-align:middle; text-align:right;border-top:0px">
                    <?= $form->field($model, 'total_sold_unit')->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                      'options' => ['readOnly' => 'true','class'=>'form-control'],
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
                  <td style="width:15%;border-top:0px"></td>
                  <td style="width:5%;border-top:0px"></td>
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
