<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StocksLineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stocks Lines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stocks-line-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Stocks Line', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'stocks_id',
            'month',
            'month_curr',
            'month_price',
            //'month_rate',
            //'unrealized_curr',
            //'unrealized_local',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
