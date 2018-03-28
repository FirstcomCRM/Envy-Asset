<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>
<h1>master/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?= Html::a(' Truncate Purchase', ['master/truncate-purchase'], ['class' => 'btn btn-default']) ?>
<?= Html::a(' Truncate Metal', ['master/truncate-metal'], ['class' => 'btn btn-default']) ?>
<?= Html::a(' Truncate Withdraw', ['master/truncate-withdraw'], ['class' => 'btn btn-default']) ?>
<?= Html::a(' Truncate Stocks', ['master/truncate-stocks'], ['class' => 'btn btn-default']) ?>
<?= Html::a(' Truncate Product', ['master/truncate-product'], ['class' => 'btn btn-default']) ?>
