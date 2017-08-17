<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\InvestorGroup;
/* @var $this yii\web\View */
/* @var $model common\models\CustomerGroupSearch */
/* @var $form yii\widgets\ActiveForm */

$data = InvestorGroup::find()->select(['customer_group'])->orderBy(['customer_group'=>SORT_ASC])->all();
$group = ArrayHelper::map($data,'customer_group','customer_group');
?>

<div class="customer-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
      <div class="col-md-6">
        <?php echo $form->field($model,'customer_group')->label(false)->widget(Select2::className(),[
                 'data'=>$group,
                 'options'=>['placeholder'=>'Investor Group '],
                 'theme'=> Select2::THEME_BOOTSTRAP,
                 'size'=> Select2::MEDIUM,
                 'pluginOptions' => [
                   'allowClear' => true
                 ],
               ]) ?>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
            <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['index'],['class' => 'btn btn-default']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
