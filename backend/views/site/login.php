<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">


    <div class=row>
      <div class="col-md-3">

      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Envy Asset</h3>
          </div>
          <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-sign-in" aria-hidden="true"></i> Login', ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
          </div>
          <div class="panel-footer text-center">
              <small><?php echo '@'.date('Y') ?> Powered by Firstcom Solutions Pte Ltd</small>
          </div>
        </div>

      </div>
      <div class="col-md-3">

      </div>
    </div>


</div>
