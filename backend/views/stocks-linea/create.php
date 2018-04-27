<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StocksLinea */

$this->title = 'Create Stocks Linea';
$this->params['breadcrumbs'][] = ['label' => 'Stocks Lineas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-linea-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
