<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Retrieve;
use common\models\PurchaseEarning;
use common\models\Investor;
use common\models\MetalUnrealisedGain;
use yii\db\Query;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PurchaseEarningSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$x = 0;
$this->title = 'Commission Future Metal';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-earning-index">

    <div class="panel panel-default">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
    </div>

    <hr>

    <?php if (!empty($searchModel->investor)): ?>
      <div class="test">
        <?php
        //  $inv = Investor::find()->where(['company_name'=>$searchModel->investor])->select(['id'])->one();
        //  $files =PurchaseEarning::find()->where(['investor'=>$inv->id])->all();

      //    $inv = Investor::find()->where(['company_name'=>$searchModel->investor])->select(['id'])->one();
        //  $files =PurchaseEarning::find()->where(['investor'=>$inv->id])->all();
          $metal = 0;
          $cummulative = 0;
        ?>

        <?php
        //  $date = PurchaseEarning::find()->select(['re_date'])->where(['investor'=>$inv->id])->distinct()->asArray()->all();
          $date = PurchaseEarning::find()->select(['re_date'])->where(['investor'=>$searchModel->investor])->distinct()->asArray()->all();

         ?>
         <table class="table table-bordered">
           <thead>
             <th>Year Month</th>
             <th>Monthly Returns</th>
             <th>Cumulative Returns</th>

             <th>Balance</th>
             <th>Commission for the Month</th>
             <th>Commission Tranche</th>

           </thead>
           <tbody>
             <?php foreach ($date as $k => $d): ?>
               <?php
                $inv_earn = PurchaseEarning::find()->where(['investor'=>$searchModel->investor,'re_date'=>$d['re_date'] ])->sum('customer_earn');
                $metal_per = PurchaseEarning::find()->where(['investor'=>$searchModel->investor,'re_date'=>$d['re_date'] ])->one();
                $total = PurchaseEarning::find()->where(['investor'=>$searchModel->investor,'re_date'=>$d['re_date'] ])->sum('purchase_amount');
                $comms = PurchaseEarning::find()->where(['investor'=>$searchModel->investor,'re_date'=>$d['re_date'] ])->sum('company_earn');
               ?>
               <tr>
                 <td><?php echo date('M Y',strtotime($d['re_date'])) ?></td>
                 <td><?php echo '$'.number_format($inv_earn,2) ?></td>
                 <td>
                   <?php
                    $metal = $metal_per->re_metal_per *100;
                    $cummulative += $metal;
                    echo number_format($cummulative,2).'%';
                   ?>
                 </td>
                 <td><?php echo '$'.number_format($total,2) ?></td>
                 <td><?php echo '$'.number_format($comms,2) ?></td>
                 <td>
                   <?php
                        $tranche = 100*$metal_per->tranche;
                        echo number_format($tranche,2).'%';
                   ?>
                 </td>



               </tr>
             <?php endforeach; ?>
           </tbody>
         </table>

      </div>
    <?php endif; ?>


</div>
