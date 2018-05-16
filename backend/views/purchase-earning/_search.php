<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Investor;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseEarningSearch */
/* @var $form yii\widgets\ActiveForm */
$data = Investor::find()->select(['id','company_name'])->orderBy(['company_name'=>SORT_ASC])->asArray()->all();
//$investor = ArrayHelper::map($data,'company_name','company_name');
$investor = ArrayHelper::map($data,'id','company_name');

?>

<div class="purchase-earning-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
      <div class="col-md-4">
          <?= $form->field($model, 'investor')->dropDownList($investor,['prompt'=>'Select Investor'])->label(false) ?>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
        </div>
      </div>
      <div class="col-md-4">

      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
