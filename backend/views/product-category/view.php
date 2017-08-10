<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductCategory */

$this->title = $model->category;
$this->params['breadcrumbs'][] = ['label' => 'Product Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-view">


  <div class="text-right">
      <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
      <?= Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-default',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post',
          ],
      ]) ?>
  </div>
  <br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category',
            'description:ntext',
        ],
    ]) ?>

</div>
