<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Stocks */

$this->title = 'Add Stock';
$this->params['breadcrumbs'][] = ['label' => 'Invest Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
