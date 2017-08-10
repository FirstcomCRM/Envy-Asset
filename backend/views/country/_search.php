<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$url = \yii\helpers\Url::to(['city-list']);
/* @var $this yii\web\View */
/* @var $model common\models\CountrySearch */
/* @var $form yii\widgets\ActiveForm */

$test = [
  '1'=>'test1',
  '2'=>'test2',
];
?>


<div class="country-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'capital') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
