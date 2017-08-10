<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
/* @var $this yii\web\View */
/* @var $model common\models\UserGroupSearch */
/* @var $form yii\widgets\ActiveForm */
$data = UserGroup::find()->select(['usergroup'])->all();
$group =  ArrayHelper::map($data,'usergroup','usergroup');

$data = null;
?>

<div class="user-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
      <div class="col-md-4">
        <?php echo $form->field($model,'usergroup')->label(false)->widget(Select2::className(),[
            'data'=>$group,
            'options'=>['placeholder'=>'User Group '],
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
    </div>

    <?php ActiveForm::end(); ?>

</div>
