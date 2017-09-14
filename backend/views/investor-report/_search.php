<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use common\models\Investor;
use common\models\ProductManagement;
/* @var $this yii\web\View */
/* @var $model common\models\PurchaseSearch */
/* @var $form yii\widgets\ActiveForm */

$data = null;
?>

<div class="purchase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
      <div class="col-md-4">
        <?php echo $form->field($model, 'date')->label(false)->widget(DateRangePicker::classname(), [
        'useWithAddon'=>false,
        'convertFormat'=>true,
        'pluginOptions'=>[
          'locale'=>[
            //'format'=> 'M j Y',
            //'format'=> 'm-d-Y',
            'format'=> 'Y-m-d',
          ],
        ],
        'options'=>[
          'placeholder'=>'Select Date Range',
          'class'=>'form-control'
        ],
    ]);?>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
              <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
              <?php echo Html::a('<i class="fa fa-envelope-open" aria-hidden="true"></i> Email',
              ['compose-email'],['class' => 'btn btn-warning', 'id'=>'email-button']) ?>
          </div>
      </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
