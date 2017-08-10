<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\DepositHead;
/* @var $this yii\web\View */
/* @var $model common\models\DepositHeadSearch */
/* @var $form yii\widgets\ActiveForm */

$data = DepositHead::find()->select(['customer'])->orderBy(['customer'=>SORT_ASC])->all();
$cust = ArrayHelper::map($data,'customer','customer');

$data = null;

?>

<div class="deposit-head-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
      <div class="row">
        <div class="col-md-4">
          <?php echo $form->field($model,'customer')->label(false)->widget(Select2::className(),[
            'data'=>$cust,
            'options'=>['placeholder'=>'Customer '],
            'theme'=> Select2::THEME_BOOTSTRAP,
            'size'=> Select2::MEDIUM,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]) ?>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
              <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
          </div>
        </div>
        <div class="col-md-4">
          <!--insert new filter here-->
        </div>
      </div>
    <?php ActiveForm::end(); ?>

</div>
