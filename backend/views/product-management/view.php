<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Retrieve;
use common\models\ProductType;
/* @var $this yii\web\View */
/* @var $model common\models\ProductManagement */

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Product Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-management-view">

    <p class="text-right">
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'product_name',
            'description:ntext',
            'product_code',

            [
              'attribute'=>'product_price',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->product_price);
              },
            ],
            [
              'attribute'=>'product_cost',
              'value'=>function($model){
                return '$'.Retrieve::retrieveFormat($model->product_cost);
              },
            ],
            [
              'attribute'=>'product_cat',
              'value'=>function($model){
                return Retrieve::retrieveProductCat($model->product_cat);
              },
            ],
            [
              'attribute'=>'product_type',
              'value'=>function($model){
                $data = ProductType::find()->where(['id'=>$model->product_type])->one();
                if (!empty($data) ) {
                    return $data->type;
                }else{
                  return $data = null;
                }
              },
            ],
            'invest_type',

        ],
    ]) ?>

</div>
