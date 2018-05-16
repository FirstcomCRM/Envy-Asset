<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Retrieve;
use common\models\PurchaseEarning;
use common\models\Forex;
/* @var $this yii\web\View */
/* @var $model common\models\Purchase */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$metal = [
  'purchase_no',
  [
    'attribute'=>'investor',
    'value'=>function($model){
      return Retrieve::retrieveInvestor($model->investor);
    },
  ],
  [
    'attribute'=>'product',
    'value'=>function($model){
      return Retrieve::retrieveProductName($model->product);
    },
  ],
    'share',
    [
      'attribute'=>'price',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->price);
      },
    ],
    [
      'attribute'=>'date',
      'format' => ['date', 'php:d M Y'],
    ],
    /*[
      'attribute'=>'expiry_date',
      'format' => ['date', 'php:d M Y'],
    ],*/
    [
      'attribute'=>'salesperson',
      'value'=>function($model){
        return Retrieve::retrieveUsernameManagement($model->salesperson);
      },
    ],
    'remarks:ntext',
    'trading_days',
    'prorated_days',
    'purchase_type',
    'charge_type',
    //s
    //'company_charge',
    [
      'attribute'=>'company_charge',
      'value'=>function($model){
        return number_format($model->company_charge*100,2);
      }
    ],

    [
      'attribute'=>'customer_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->customer_earn);
      },
    ],
    [
      'attribute'=>'company_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->company_earn);
      },
    ],
    [
      'attribute'=>'staff_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->staff_earn);
      },
    ],
];

$nickel = [
  'purchase_no',
  [
    'attribute'=>'investor',
    'value'=>function($model){
      return Retrieve::retrieveInvestor($model->investor);
    },
  ],
  [
    'attribute'=>'product',
    'value'=>function($model){
      return Retrieve::retrieveProductName($model->product);
    },
  ],
    'share',
    [
      'attribute'=>'price',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->price);
      },
    ],
    [
      'attribute'=>'date',
      'format' => ['date', 'php:d M Y'],
    ],
    [
      'attribute'=>'nickel_date',
      'format' => ['date', 'php:d M Y'],
    ],
    [
      'attribute'=>'nickel_expiry',
      'format' => ['date', 'php:d M Y'],
    ],

    [
      'attribute'=>'salesperson',
      'value'=>function($model){
        return Retrieve::retrieveUsernameManagement($model->salesperson);
      },
    ],
    'remarks:ntext',
    'purchase_type',
    'charge_type',
    //s
    //'company_charge',
    [
      'attribute'=>'company_charge',
      'value'=>function($model){
        return number_format($model->company_charge*100,2);
      }
    ],

    [
      'attribute'=>'customer_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->customer_earn);
      },
    ],
    [
      'attribute'=>'company_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->company_earn);
      },
    ],
    [
      'attribute'=>'staff_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->staff_earn);
      },
    ],
];

$stocks = [
  'purchase_no',
  [
    'attribute'=>'investor',
    'value'=>function($model){
      return Retrieve::retrieveInvestor($model->investor);
    },
  ],
  [
    'attribute'=>'product',
    'value'=>function($model){
      return Retrieve::retrieveProductName($model->product);
    },
  ],
    'share',
    [
      'attribute'=>'price',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->price);
      },
    ],
    [
      'attribute'=>'date',
      'format' => ['date', 'php:d M Y'],
    ],

    [
      'attribute'=>'salesperson',
      'value'=>function($model){
        return Retrieve::retrieveUsernameManagement($model->salesperson);
      },
    ],
    'remarks:ntext',
    'purchase_type',
    'charge_type',
    //s
    //'company_charge',
    [
      'attribute'=>'company_charge',
      'value'=>function($model){
        return number_format($model->company_charge*100,2);
      }
    ],

    [
      'attribute'=>'customer_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->customer_earn);
      },
    ],
    [
      'attribute'=>'company_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->company_earn);
      },
    ],
    [
      'attribute'=>'staff_earn',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->staff_earn);
      },
    ],

    [
      'attribute'=>'buy_currency',
      'value'=>function($model){
        $data = Forex::findOne($model->buy_currency);
        return $data->currency_code;
      }
    ],
    [
      'attribute'=>'buy_curr_rate',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->buy_curr_rate);
      },
    ],
    [
      'attribute'=>'buy_units',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->buy_units);
      },
    ],
    [
      'attribute'=>'buy_in_price',
      'value'=>function($model){
        return '$'.Retrieve::retrieveFormat($model->buy_in_price);
      },
    ],
    [
      'attribute'=>'ptotal_sold_unit',
      'value'=>function($model){
        return Retrieve::retrieveFormat($model->ptotal_sold_unit);
      },
    ],

];

$data = PurchaseEarning::find()->where(['purchase_id'=>$model->id])->asArray()->all();

$customer_sum = PurchaseEarning::find()->where(['purchase_id'=>$model->id])->sum('customer_earn');
$company_sum = PurchaseEarning::find()->where(['purchase_id'=>$model->id])->sum('company_earn');
$staff_sum = PurchaseEarning::find()->where(['purchase_id'=>$model->id])->sum('staff_earn');
$customer_sum_after =  PurchaseEarning::find()->where(['purchase_id'=>$model->id])->sum('customer_earn_after');

?>
<div class="purchase-view">

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


     <?php if ($model->purchase_type=='Metal'): ?>
       <?= DetailView::widget([
           'model' => $model,
           'attributes' => $metal,
       ]) ?>
       <table class="table table-bordered">
         <thead>
           <th>Year-Month</th>
           <th>Metal %</th>
           <th>Investor Return (Before)</th>
           <th>Investor Return (After)</th>
           <th>Company Commission</th>
           <th>Staff Commission</th>
         </thead>
         <tbody>
           <?php foreach ($data as $key => $value): ?>
               <tr>
                 <td><?php echo date('M Y',strtotime($value['re_date']) ) ?></td>
                 <td><?php echo ($value['re_metal_per']*100).'%' ?></td>
                 <td><?php echo '$'.number_format($value['customer_earn'],2) ?></td>
                 <td><?php echo '$'.number_format($value['customer_earn_after'],2) ?></td>
                 <td><?php echo '$'.number_format($value['company_earn'],2)  ?></td>
                 <td><?php echo '$'.number_format($value['staff_earn'],2) ?></td>
               </tr>
           <?php endforeach; ?>
         </tbody>
         <tfoot>
           <td></td>
           <td></td>
           <td><?php echo '$'.number_format($customer_sum,2)  ?></td>
           <td><?php echo '$'.number_format($customer_sum_after,2)  ?></td>
           <td><?php echo '$'.number_format($company_sum,2)  ?></td>
           <td><?php echo '$'.number_format($staff_sum,2)  ?></td>
         </tfoot>
       </table>
     <?php elseif($model->purchase_type=='Nickel'): ?>
          <?= DetailView::widget([
             'model' => $model,
             'attributes' => $nickel,
          ]) ?>
      <?php else: ?>
          <?= DetailView::widget([
              'model' => $model,
              'attributes' => $stocks,
          ]) ?>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Stocks Sold Details</h3>
            </div>
            <div class="panel-body">
              <?php Pjax::begin(); ?>
                 <?= GridView::widget([
                  'dataProvider' => $dataProvider_line,
                //  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],

                    [
                      'attribute'=>'psold_date',
                      'format' => ['date', 'php:d M Y'],
                    ],
                    //'psold_currency',
                    [
                      'attribute'=>'psold_currency',
                      'value'=>function($model){
                        $data = Forex::findOne($model->psold_currency);
                        return $data->currency_code;
                      }
                    ],
                    'pcurrency_rate',

                    [
                      'attribute'=>'psold_price',
                      'value'=>function($model){
                        return '$'.Retrieve::retrieveFormat($model->psold_price);
                      },
                    ],
                    [
                      'attribute'=>'psold_units',
                      'value'=>function($model){
                        return Retrieve::retrieveFormat($model->psold_units);
                      },
                    ],
                    [
                      'attribute'=>'pbalance',
                      'value'=>function($model){
                        return '$'.Retrieve::retrieveFormat($model->pbalance);
                      },
                    ],

                  ],
              ]); ?>
            <?php Pjax::end(); ?>
            </div>
          </div>

     <?php endif; ?>



</div>
