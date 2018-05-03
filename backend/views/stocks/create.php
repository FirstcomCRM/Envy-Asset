<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Stocks */

$this->title = 'Create Stocks';
$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-create">



    <?= $this->render('_form', [
        'model' => $model,
        'modelLine'=> $modelLine,
        'modelLinea'=>$modelLinea,
    ]) ?>

</div>
