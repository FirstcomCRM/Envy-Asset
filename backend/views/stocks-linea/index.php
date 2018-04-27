<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StocksLineaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stocks Lineas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-linea-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Stocks Linea', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'stocks_id',
            'sold_date',
            'sold_currency',
            'currency_rate',
            //'sold_price',
            //'sold_units',
            //'balance',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
