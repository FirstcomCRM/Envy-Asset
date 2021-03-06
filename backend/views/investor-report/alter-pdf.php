<?php

use yii\db\Query;
use common\components\Retrieve;
use common\models\MetalAl;
use common\models\MetalCu;
use common\models\MetalAu;
use common\models\MetalNi;
use common\models\MetalOil;
use common\models\MetalZn;
use common\models\MetalUnrealised;
use common\models\MetalUnrealisedGain;
use common\models\Purchase;
use common\models\PurchaseEarning;
use common\models\Withdraw;
use common\models\Stocks;
use common\models\StocksLine;
use common\models\Investor;
use common\models\ProductManagement;
use common\models\Forex;

?>

<?php

$start_search = date('Y-m-01',strtotime($searchModel->date_filter) );
$start_end = date('Y-m-t',strtotime($searchModel->date_filter));

$d = new \DateTime($start_search);
$d->modify('-1month');
$reduc_date_end = $d->format('Y-m-t');
//$d->modify('-2month');
$d->modify('-12month');
$reduc_date_start = $d->format('Y-m-d');


$al = MetalAl::find()->where(['date_uploaded'=>$start_search])->all();
$cu = MetalCu::find()->where(['date_uploaded'=>$start_search])->all();
$au = MetalAu::find()->where(['date_uploaded'=>$start_search])->all();
$ni = MetalNi::find()->where(['date_uploaded'=>$start_search])->all();
$oil = MetalOil::find()->where(['date_uploaded'=>$start_search])->all();
$zn = MetalZn::find()->where(['date_uploaded'=>$start_search])->all();

$unrealised = MetalUnrealised::find()->where(['date_uploaded'=>$start_search])->all();
$unrealisedgain =MetalUnrealisedGain::find()->where(['date_uploaded'=>$start_search])->one();

$pur_metal = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Metal','type'=>'Investor'])->asArray()->all();
$pur_metal_prev =Purchase::find()->andFilterWhere(['investor'=>$model->id, 'purchase_type'=>'Metal','type'=>'Investor'])
      ->andFilterWhere(['between','date',$reduc_date_start,$reduc_date_end])
      ->sum('price');
$pur_metal_current =Purchase::find()->andFilterWhere(['investor'=>$model->id, 'purchase_type'=>'Metal','type'=>'Investor'])
      ->andFilterWhere(['between','date',$start_search,$start_end])
      ->sum('price');
$pur_metal_curr = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Metal','type'=>'Investor'])
          ->andFilterWhere(['between','date',$start_search,$start_end])
          ->asArray()
          ->all();

$pur_nickel_curr_ma = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Nickel','type'=>'Investor','nickel_state'=>'Mature'])
          //  ->andFilterWhere(['between','date',$start_search,$start_end])
            ->andFilterWhere(['between','true_expiry_date',$start_search,$start_end])
            ->asArray()->all();
$pur_nickel_curr_im = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Nickel','type'=>'Investor','nickel_state'=>'Immature'])
          //  ->andFilterWhere(['between','date',$start_search,$start_end])
            ->andFilterWhere(['between','date',$start_search,$start_end])
            ->asArray()->all();

$pur_nickel_prev = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Nickel','type'=>'Investor'])
            ->andFilterWhere(['between','date',$reduc_date_start,$reduc_date_end])
          //  ->andFilterWhere(['between','date',$reduc_date_start,$start_end]) //edrfix
            ->asArray()->all();
$pur_nickel_prev_im = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Nickel','type'=>'Investor','nickel_state'=>'Immature'])
            //  ->andFilterWhere(['between','date',$reduc_date_start,$reduc_date_end])
            ->andFilterWhere(['between','date',$reduc_date_start,$start_end]) //edrfix
              ->asArray()->all();

$pur_nickel_prev_sum = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Nickel','type'=>'Investor'])
        ->andFilterWhere(['between','date',$reduc_date_start,$reduc_date_end])
      //  ->andFilterWhere(['between','date',$reduc_date_start,$start_end])
        ->sum('price');
$pur_nickel_curr_sum = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Nickel','type'=>'Investor'])
        ->andFilterWhere(['between','date',$start_search,$start_end])
        ->sum('price');

$pur_stocks_prev =Purchase::find()->andFilterWhere(['investor'=>$model->id, 'purchase_type'=>'Stocks','type'=>'Investor'])
        ->andFilterWhere(['between','date',$reduc_date_start,$reduc_date_end])
        ->sum('price');
$pur_stocks_current =Purchase::find()->andFilterWhere(['investor'=>$model->id, 'purchase_type'=>'Stocks','type'=>'Investor'])
        ->andFilterWhere(['between','date',$start_search,$start_end])
        ->sum('price');

$metals_curr = Withdraw::find()->where(['between','date',$start_search,$start_end])->andFilterWhere(['investor'=>$model->id,'product_type'=>2,'type'=>'Investor'])->asArray()->all();
$nickels_curr = Withdraw::find()->where(['between','date',$start_search,$start_end ])->andFilterWhere(['investor'=>$model->id,'product_type'=>3,'type'=>'Investor'])->asArray()->all();
$metals_curr_sum = Withdraw::find()->where(['between','date',$start_search,$start_end])->andFilterWhere(['investor'=>$model->id,'product_type'=>2,'type'=>'Investor'])->sum('price');
$nickels_curr_sum = Withdraw::find()->where(['between','date',$start_search,$start_end])->andFilterWhere(['investor'=>$model->id,'product_type'=>3,'type'=>'Investor'])->sum('price');
$stocks_curr_sum = Withdraw::find()->where(['between','date',$start_search,$start_end])->andFilterWhere(['investor'=>$model->id,'product_type'=>1,'type'=>'Investor'])->sum('price');


$metals_prev = Withdraw::find()->where(['between','date',$reduc_date_start,$reduc_date_end])->andFilterWhere(['investor'=>$model->id,'product_type'=>2,'type'=>'Investor'])->asArray()->all();
$nickels_prev = Withdraw::find()->where(['between','date',$reduc_date_start,$reduc_date_end ])->andFilterWhere(['investor'=>$model->id,'product_type'=>3,'type'=>'Investor'])->asArray()->all();
$metals_prev_sum = Withdraw::find()->where(['between','date',$reduc_date_start,$reduc_date_end])->andFilterWhere(['investor'=>$model->id,'product_type'=>2,'type'=>'Investor'])->sum('price');
$nickels_prev_sum = Withdraw::find()->where(['between','date',$reduc_date_start,$reduc_date_end ])->andFilterWhere(['investor'=>$model->id,'product_type'=>3,'type'=>'Investor'])->sum('price');
$stocks_prev_sum = Withdraw::find()->where(['between','date',$reduc_date_start,$reduc_date_end ])->andFilterWhere(['investor'=>$model->id,'product_type'=>1,'type'=>'Investor'])->sum('price');

//$stocks = Stocks::find()->where(['between','date',$start_search,$start_end])->asArray()->limit(3)->all();
$stocks = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Stocks','type'=>'Investor'])->asArray()->limit(3)->all();
$stocks_prev = Purchase::find()->andFilterWhere(['investor'=>$model->id, 'purchase_type'=>'Stocks','type'=>'Investor'])
      ->andFilterWhere(['between','date',$reduc_date_start,$reduc_date_end])
      ->sum('price');
$stocks_current = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Stocks','type'=>'Investor'])
    ->andFilterWhere(['between','date',$start_search,$start_end])
    ->sum('price');
//$pur_nickel = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Nickel'])->asArray()->all();

$inv = Investor::find()->where(['id'=>$model->id])->one();

$dates = PurchaseEarning::find()->select(['re_date'])->where(['investor'=>$model->id,'ptype'=>'Investor'])->distinct()->asArray()->all();
//$fmt_trade = PurchaseEarning::find()->where(['investor'=>$model->id, 're_date'=>$reduc_date_start])->asArray()->all();
$fmt_trade_sum = PurchaseEarning::find()->where(['investor'=>$model->id, 're_date'=>$reduc_date_start,'ptype'=>'Investor'])->sum('customer_earn_after');



//
//previous ending balance queries
$previous_ending_balance = 0;
$previous_metal_balance = 0;
$previous_nickel_balance = 0;
$previous_stocks_balance = 0;
$nearn = 0;
foreach ($pur_metal as $key => $value) {
//  $nearning = PurchaseEarning::find()->where(['purchase_id'=>$value['id'],'re_date'=>$reduc_date_start])->asArray()->all();
  $nearning = PurchaseEarning::find()->where(['purchase_id'=>$value['id']])
      ->andWhere(['between','re_date',$reduc_date_start,$reduc_date_end])
      ->asArray()->all();

  foreach ($nearning as $k => $v) {
    $nearn = $nearn+$v['customer_earn_after'];
  }
}

$nickels_prev_cearn = Purchase::find()->where(['investor'=>$model->id, 'purchase_type'=>'Nickel'])
            ->andFilterWhere(['between','date',$reduc_date_start,$reduc_date_end])
            ->sum('customer_earn');

$previous_metal_balance = $pur_metal_prev+$nearn-($metals_prev_sum);
//$previous_nickel_balance = $pur_nickel_prev_sum + $nickels_prev_cearn - ($nickels_prev_sum);
$previous_nickel_balance = $pur_nickel_prev_sum;
$previous_stocks_balance = $pur_stocks_prev +$stocks_prev_sum - ($stocks_prev_sum);
$previous_ending_balance = $previous_metal_balance+$previous_nickel_balance+$previous_stocks_balance;


//echo $reduc_date_start;
//edr001
//end

$withdraw_metal = 0;
$withdraw_nickel = 0;

$custom_metal_sum = 0;
$company_metal_sum = 0;

$company_nickel_sum = 0;
$custom_nickel_sum = 0;

$metal_invest = 0;
$nickel_invest = 0;
$metal_wi_total = 0;
$nickel_wi_total = 0;

$fmt = 0;
$fmt_diff = 0;
$pmt = 0;
$bb = [];

//$prev_total = $pur_metal_prev+$stocks_prev+$pur_nickel_prev_sum;
//$prev_curr = $pur_metal_current+$stocks_current+$pur_nickel_curr_sum;


 ?>
<style>
    table{
      width:100%;
      border-collapse: collapse;

    }


  .head{
    margin-bottom: 15px;
  }

  .page-break{
    page-break-after: always;
  }

  .cover-image{
    text-align: center;
  }


  .th-daily,
  .th-oil{
    padding 5px;
    background-color: #E87349;
    color:white;
    font-weight:bold;
  }

  .th-title{
    background-color:#002041;
    color: #FFD839;
    padding: 5px;
  }

  .th-daily-blue{
    background-color:#002041;
    color:#C7AF3E;

  }

  .td-metal{
    padding:5px;
  }

  .td-metal-sum{
    padding:5px;
    width:20%;
  }
  .td-metal-sum-percent{
    padding:5px;
    text-align: right;
    color: #3AB050;
  }

  .td-daily{
    padding:5px;
    width:25%;
    text-align: center;
    font-weight: bold;
  }

  .td-oil{
    padding:5px;
    width:14%;
    text-align: center;
  }

  .investor-report{
    width: 100%;
    border-collapse: collapse;
  }
  .investor-td{
    width:14%;
    padding:8px;
  }
  .commentary{
    text-align: justified;
  }

  .rights{
    text-align: right;
  }


</style>



<div class="cover-image">

  <?php  $front = Yii::getAlias('@images').'/'.'front-page.png' ?>
  <?php  $logo = Yii::getAlias('@images').'/'.'logo.png' ?>
  <img src="<?php echo $logo ?>" alt="logo" class="front-page">
  <img src="<?php echo $front ?>" alt="Front" class="front-page">
  <div class="cover-description">
    <h1><strong>Investor Report</strong></h1>
    <h3>As of <?php echo date('d M Y' ,strtotime($start_end) ) ?></h3>
    <h3>Prepared by Envy Asset Management Pte Ltd</h3>
  </div>
</div>

<div class="page-break">

</div>


<div class="test">

</div>


<div class="Comment">
  <h2>COMMENTARY</h2>
  <h4>Commodities</h4>
  <p class="commentary">
    April is a significantly shorter trading month as compared to months, coupled with the volatility in prices, less trades were made this month. The lower than expected performance stems from losses incurred from the long positions in Nickel entered into in March. The sharp fall in Nickel prices was primarily due to developments in the Philippines – namely parliament rejecting to confirm acting environmental minister Gina Lopez. In her 10-months as acting environment minister, Ms. Duterte suspended the licenses of many miners after inspections found that they were violating environmental regulations. In February, 23 mines were ordered closed, mainly nickel producers. The suspensions were estimated to remove about 50% of the country’s nickel output, which amounted to 10% of global supply. Nickel prices, which had already rallied on the possibility of the suspensions climbed to $10,500 after the announcement.
  </p>
  <p class="commentary">
    Generally, the correction in the base metals continues, copper prices have joined nickel in breaking below recent, important, support levels so the question is will the others follow? With oil, iron ore and steel prices, also falling heavily, the path of least resistance is to the downside for now. We are not overly bearish on the outlook for global growth; some metals’ fundamentals have potentially changed, i.e. in nickel with regards to supply from the Philippines, but we generally see this weakness as coming from stale long liquidation following the rally when prices ran ahead of the fundamentals during the Trump reflation trade. We are also pretty sure it will not be a straight-line fall in prices as such we have entered into long positions to capitalise on any short-term rebounds in prices.
  </p>
  <h4>Securities</h4>
  <p class="commentary">
    After the worst start to a year ever, the stock market surged to new highs in 2016. All the major indexes rebounded to record levels and defied the doomsday forecasts that preceded events like Brexit and President-elect Donald Trump's election. The volatility looks set to conitnue into 2017. As such, our fund is adopting a wait-and-see approach before entering the market.
  </p>
</div>

<div class="page-break">

</div>

<div class="breakdown">
  <h4>Appendix I - Breakdown</h4>
  <table class"previous-balance">
    <tr>
      <td style="width:15%"></td>
      <td style="width:40%"></td>
      <td style="width:15%"> </td>
      <td style="width:20%" class="rights">SGD</td>
      <td style="width:10%"></td>
    </tr>
    <tr>
      <td class="th-daily">Date</td>
      <td class="th-daily">Beginning Balance as at <?php echo date('d M Y',strtotime($start_search) ); ?></td>
      <td class="th-daily"></td>
      <td class="th-daily rights"><?php echo number_format($previous_ending_balance,2) ?></td>
      <td class="th-daily"></td>
    </tr>
      <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <!--Empty Space--->
    <tr>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"><strong>Futures Metal Trading (Metal)</strong></td>
      <td style="border-bottom:1px solid black"></td>
      <td class="rights" style="border-bottom:1px solid black">
        <strong><?php echo number_format($previous_metal_balance,2) ?></strong>
      </td>
      <td></td>
    </tr>
      <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <!--Empty Space--->
    <tr>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"><strong>Securities (Stocks)</strong></td>
      <td style="border-bottom:1px solid black"></td>
      <td class="rights" style="border-bottom:1px solid black">
        <strong>
          <?php echo number_format($previous_stocks_balance,2) ?>
        </strong>
      </td>
      <td></td>
    </tr>
      <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <!--Empty Space--->
    <tr>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"><strong>Physical Metal Trading (Nickel)</strong></td>
      <td style="border-bottom:1px solid black"></td>
      <td class="rights" style="border-bottom:1px solid black"> <strong><?php echo number_format($previous_nickel_balance,2) ?></strong></td>
      <td></td>
    </tr>

    <!---Nickel Contract loop--->
    <?php foreach ($pur_nickel_prev  as $key => $nickel): ?>
      <tr>
        <td></td>
        <td>
          <?php $data = ProductManagement::findOne($nickel['product']);
            echo $data->product_name;
          ?>

        </td>
        <td></td>
        <td class="rights"><?php echo number_format($nickel['price'],2) ?></td>
        <td></td>
      </tr>
    <?php endforeach; ?>

    <!---Nickel Contract loop--->

  </table>

  <br>

  <table class="current-transact">
    <tr>
      <td style="width:15%"></td>
      <td style="width:40%"></td>
      <td style="width:15%" class="rights">SGD</td>
      <td style="width:20%" class="rights">SGD</td>
      <td style="width:10%"></td>
    </tr>
    <tr>
      <td class="th-daily"></td>
      <td class="th-daily">Transactions during the month </td>
      <td class="th-daily rights">Debit</td>
      <td class="th-daily rights">Credit</td>
      <td class="th-daily"></td>
    </tr>
      <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <!--Empty Space--->
    <tr>
      <td></td>
      <td><strong>Futures Metal Trading (Metal)</strong></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>

    <!--Looping sequence for Future Metal Trading Records--->
    <?php foreach ($pur_metal as $key => $value): ?>//edr00
      <?php $earning = PurchaseEarning::find()->where(['purchase_id'=>$value['id'],'re_date'=>$start_search])->asArray()->all() ?>
        <?php foreach ($earning as $k => $v): ?>
          <tr>
            <td><?php echo date('d M Y',strtotime($v['re_date']) ) ?></td>
            <td>Realised profits from Futures Metal Trading </td>
            <?php $nums = number_format($v['customer_earn'],2); ?>
            <td></td>
            <td class="rights"><?php echo $nums ?></td>
            <?php $custom_metal_sum = $custom_metal_sum+$v['customer_earn']; ?>
            <td></td>
          </tr>
          <tr>
            <td><?php echo date('d M Y',strtotime($v['re_date']) ) ?></td>
            <td>Commission charged </td>
            <td class="rights"><?php echo '('.number_format($v['company_earn'],2).')'; ?></td>
            <td></td>
            <td></td>
            <?php $company_metal_sum = $company_metal_sum+$v['company_earn']; ?>
            <?php $fmt =  $custom_metal_sum - $company_metal_sum?>
          </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <!--Looping sequence for Future Metal Trading Records--->

    <tr>
      <td></td>
      <td>Realised Profits (Metal)</td>
      <td> </td>
      <td class="rights" style="border-top:1px solid black;border-bottom:1px solid black;"><strong>
         <?php $fmt =  $custom_metal_sum - $company_metal_sum;
          echo number_format($fmt,2);
         ?></strong>
       </td>
      <td> </td>
    </tr>

      <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <!--Empty Space--->

    <!--Looping sequence for Future Metal Trading/Metals Records Withddraw/Investment //edr00--->
    <?php foreach ($metals_curr as $key => $m): ?>
      <tr>
        <td><?php echo date('d M Y',strtotime($m['date']) ) ?></td>
        <td>
          Metal withdraw from <?php echo date('d M Y',strtotime($m['date']) ) ?>
          <?php $data = ProductManagement::findOne($m['product']);
            echo $data->product_name;
          ?>
        </td>
        <td class="rights"><?php echo '('.number_format($m['price'],2).')' ?></td>
        <td></td>
        <td></td>
      </tr>
    <?php endforeach; ?>


    <?php foreach ($pur_metal_curr as $key => $m): ?>
      <tr>
        <td><?php echo date('d M Y',strtotime($m['date']) ) ?></td>
        <td>
          Metal investment from <?php echo date('d M Y',strtotime($m['date']) ) ?>
          <?php $data = ProductManagement::findOne($m['product']);
            echo $data->product_name;
          ?>
        </td>
        <td></td>
        <td class="rights"><?php echo number_format($m['price'],2) ?></td>
        <td></td>
      </tr>
      <?php $metal_invest = $metal_invest + $m['price']?>
    <?php endforeach; ?>
    <!--Looping sequence for Physical Metal Trading Records Withdraw?investment--->

    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td class="rights" style="border-top:1px solid black;border-bottom:1px solid black;">
        <strong>
          <?php
          //  $metal_wi_total = $metals_curr_sum - $metal_invest;
            $metal_wi_total =  $metal_invest - $metals_curr_sum ;
            echo number_format($metal_wi_total,2);
          ?>
        </strong>
      </td>
      <td> </td>
    </tr>

    <tr>
      <td></td>
      <td><strong>Physical Metal Trading (Nickel)</strong></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>

    <!--Looping sequence for Physical Metal Trading Records--->

    <?php foreach ($pur_nickel_curr_ma as $key => $nickel): ?>
        <tr>
          <td><?php echo date('d M Y', strtotime($nickel['true_expiry_date']) ) ?></td>
          <td>
            Realised profits from
            <?php $data = ProductManagement::findOne($nickel['product']);
              echo $data->product_name;
            ?>
          </td>
          <td></td>
          <td class="rights"><?php echo number_format($nickel['customer_earn'],2) ?></td>
          <?php $custom_nickel_sum+=$nickel['customer_earn'] ?>
          <td></td>
        </tr>
        <tr>
          <td><?php echo date('d M Y', strtotime($nickel['true_expiry_date']) ) ?></td>
          <td>Commission charged </td>
          <td class="rights"><?php echo '('.number_format($nickel['company_earn'],2).')'; ?></td>
          <?php $company_nickel_sum+=$nickel['company_earn']?>
          <td></td>
          <td></td>
        </tr>
    <?php endforeach; ?>
    <!--Looping sequence for Physical Metal Trading Records--->

    <tr>
      <td></td>
      <td>Realised Profits</td>
      <?php $pmt =  $custom_nickel_sum - $company_nickel_sum?>
      <td> </td>
      <td class="rights" style="border-top:1px solid black;border-bottom:1px solid black;"><strong><?php echo number_format($pmt,2) ?></strong></td>
      <td> </td>
    </tr>

    <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <!--Empty Space--->

    <!--Looping sequence for Physical Metal Trading/Nickel Records Withddraw/Investment edr01--->
    <?php foreach ($nickels_curr as $key => $n): ?>
      <tr>
        <td><?php echo date('d M Y',strtotime($n['date']) ) ?></td>
        <td>
          Nickel withdraw from
          <?php $data = ProductManagement::findOne($n['product']);
            echo $data->product_name;
          ?>
        </td>
        <td class="rights"><?php echo '('.number_format($n['price'],2).')' ?></td>
        <td></td>
        <td></td>
      </tr>
    <?php endforeach; ?>

    <?php foreach ($pur_nickel_curr_im as $key => $n): ?>
      <tr>
        <td><?php echo date('d M Y',strtotime($n['date']) ) ?></td>
        <td>
          Nickel investment from
          <?php $data = ProductManagement::findOne($n['product']);
            echo $data->product_name;
          ?>
        </td>
        <td></td>
        <td class="rights"><?php echo number_format($n['price'],2) ?></td>
        <td></td>
      </tr>
      <?php $nickel_invest = $nickel_invest + $n['price']?>
    <?php endforeach; ?>
    <!--Looping sequence for Physical Metal Trading Records Withdraw?investment--->

    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td class="rights" style="border-top:1px solid black;border-bottom:1px solid black;">
        <strong>
          <?php
          //  $nickel_wi_total = $nickels_curr_sum -  $nickel_invest;
            $nickel_wi_total =   $nickel_invest-$nickels_curr_sum;
            echo number_format($nickel_wi_total,2);
          ?>
        </strong>
      </td>
      <td> </td>
    </tr>
  </table>

  <br>

  <?php
      $eb = 0;
      $eb =  ($metal_wi_total+$fmt+$pmt+$nickel_wi_total+$stocks_current);
      $fmt_sum = $metal_wi_total+$fmt;
      $pmt_sum = $pmt+$nickel_wi_total;

      //Ending balance queries
      $current_metal_balance = 0;
      $current_nickel_balance = 0;
      $current_stocks_balance = 0;
      $current_ending_balance = 0;

      $current_metal_balance = $previous_metal_balance + $fmt + $metal_wi_total;
      $current_nickel_balance = $previous_nickel_balance + $pmt + $nickel_wi_total;
      $current_stocks_balance = $previous_stocks_balance + $stocks_current - $stocks_curr_sum;
      $current_ending_balance = $current_metal_balance+$current_nickel_balance+$current_stocks_balance;
      //edr border
  ?>
<hr>

  <table class="current-balance">
    <tr>
      <td style="width:15%"></td>
      <td style="width:40%"></td>
      <td style="width:15%"> </td>
      <td style="width:20%" class="rights">SGD</td>
      <td style="width:10%"></td>
    </tr>
    <tr>
      <td class="th-daily">Date</td>
      <td class="th-daily">Ending Balance as at <?php echo date('d M Y', strtotime($start_end) ); ?></td>
      <td class="th-daily"></td>
      <td class="th-daily rights"><?php echo number_format($current_ending_balance,2) ?></td>
      <td class="th-daily"></td>
    </tr>
      <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <!--Empty Space--->
    <tr>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"><strong>Futures Metal Trading (Metal)</strong></td>
      <td style="border-bottom:1px solid black"></td>
      <td class="rights" style="border-bottom:1px solid black">
         <strong><?php echo number_format($current_metal_balance,2) ?></strong>
      </td>
      <td></td>
    </tr>
      <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <!--Empty Space--->
    <tr>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"><strong>Securities (Stocks)</strong></td>
      <td style="border-bottom:1px solid black"></td>
      <td class="rights" style="border-bottom:1px solid black">
        <strong>
          <?php echo number_format($current_stocks_balance,2) ?>
        </strong>
      </td>
      <td></td>
    </tr>
      <!--Empty Space--->
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <!--Empty Space--->
    <tr>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"><strong>Physical Metal Trading (Nickel)</strong></td>
      <td style="border-bottom:1px solid black"></td>
      <td class="rights" style="border-bottom:1px solid black"> <strong><?php echo number_format($current_nickel_balance,2) ?></strong></td>
      <td></td>
    </tr>

    <!---Nickel Contract loop edr00--->
    <?php foreach ($pur_nickel_prev_im  as $key => $nickel): ?>
       <tr>
         <td></td>
         <td>
           <?php $data = ProductManagement::findOne($nickel['product']);
            echo $data->product_name;
          ?>
         </td>
         <td></td>
         <td class="rights"><?php echo number_format($nickel['price'],2) ?></td>
         <td></td>
       </tr>
     <?php endforeach; ?>
    <!---Nickel Contract loop--->
    <tr>
      <td></td>
      <td>
        Payables
      </td>
      <td></td>
      <td class="rights"><?php echo number_format($pmt,2) ?></td>
      <td></td>
    </tr>

  </table>

  <br>


  <!--edr end 3rd table of appendix 1--->

</div>

<div class="page-break">

</div>

<div class="appendice-metals">
  <h2>Appendix II-Metals</h2>
  <table border="1" class="table-metal">
    <thead>
      <tr>
        <th class="th-daily">Commodity</th>
        <th class="th-daily">Position</th>
        <th class="th-daily">Entry Date</th>
        <th class="th-daily">Entry Price</th>
        <th class="th-daily">Entry Value</th>
        <th class="th-daily">Exit Date</th>
        <th class="th-daily">Exit Price</th>
        <th class="th-daily">Exit Value</th>
        <th class="th-daily" colspan = "2">Realised Gain/Loss</th>
        <th class="th-daily" colspan = "2">Profit/Loss after transaction fees</th>

      </tr>
    </thead>
      <tr>
        <th></th>
        <th></th>
        <th>USD</th>
        <th>USD</th>
        <th>USD</th>
        <th>USD</th>
        <th>USD</th>
        <th>USD</th>
        <th>USD</th>
        <th>%</th>
        <th>USD</th>
        <th>SGD</th>
      </tr>
      <?php foreach ($unrealised as $key => $value): ?>
        <tr>
        <td class="td-metal"><?php echo $value->commodity ?></td>
        <td class="td-metal"><?php echo $value->position ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveDate_mdy($value->entry_date_usd) ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveFormat($value->entry_price_usd) ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveFormat($value->entry_value_usd) ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveDate_mdy($value->exit_date_usd) ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveFormat($value->exit_price_usd) ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveFormat($value->exit_value_usd) ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveFormat($value->realised_gain_usd) ?></td>
        <td class="td-metal"><?php echo $value->realised_gain_percent ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveFormat($value->profit_lost_usd) ?></td>
        <td class="td-metal"><?php echo Retrieve::retrieveFormat($value->profit_lost_sgd) ?></td>
        </tr>
      <?php endforeach; ?>

  </table>
  <br>


  <table border=1 class="table-metal-sum">
    <tr>
      <td colspan = "4" class="td-metal-sum">Realised Gain/(Loss)</td>
      <td colspan = "2" class="td-metal-sum rights"><?php echo Retrieve::retrieveFormat($unrealisedgain->re_usd)?></td>
      <td colspan = "2" class="td-metal-sum">USD</td>
      <td colspan = "2" class="td-metal-sum rights"><?php echo Retrieve::retrieveFormat($unrealisedgain->re_usd) ?></td>
      <td colspan = "2" class="td-metal-sum">SGD</td>
    </tr>
    <tr>
      <td colspan = "4" class="td-metal-sum"></td>
      <td colspan = "2" class="td-metal-sum"></td>
      <td colspan = "2" class="td-metal-sum"></td>
      <td colspan = "2" class="td-metal-sum-percent">
        <?php $re_percent = $unrealisedgain->re_gain_loss*100; ?>
        <?php  echo $re_percent.'%'?>
      </td>
      <td colspan = "2" class="td-metal-sum"></td>
    </tr>
    <tr>
      <td colspan = "4" class="td-metal-sum">Unrealised Gain/(Loss)</td>
      <td colspan = "2" class="td-metal-sum rights"><?php echo Retrieve::retrieveFormat($unrealisedgain->usd) ?></td>
      <td colspan = "2" class="td-metal-sum">USD</td>
      <td colspan = "2" class="td-metal-sum rights"><?php echo Retrieve::retrieveFormat($unrealisedgain->sgd) ?></td>
      <td colspan = "2" class="td-metal-sum">SGD</td>
    </tr>
    <tr>
      <td colspan = "4" class="td-metal-sum"></td>
      <td colspan = "2" class="td-metal-sum"></td>
      <td colspan = "2" class="td-metal-sum"></td>
      <td colspan = "2" class="td-metal-sum-percent">
        <?php $percent = $unrealisedgain->gain_loss*100; ?>
        <?php  echo $percent.'%'?>
      </td>
      <td colspan = "2" class="td-metal-sum"></td>
    </tr>
  </table>
</div>

<div class="page-break">

</div>



<div class="appendice-III">
    <h2>Appendix III - Stocks </h2>
    <table border="1"  class="stocks-list">
      <thead>
        <tr>
          <th  style="width:20%" class="th-daily-blue"><?php echo $inv->company_name ?></th>
          <?php if (!empty($stocks)): ?>
            <?php foreach ($stocks as $k => $s): ?>
              <th class="th-daily">
                <?php
                  $data = ProductManagement::findOne($s['product']);
                  echo $data->product_name;
                ?>
              </th>
            <?php endforeach; ?>
          <?php else: ?>
            <th class="th-daily"> <h4>-</h4></th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Ticker</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php //echo $s['stock'] echo ''?>
                  <?php
                    $data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();
                    echo $data->ticker;
                  ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Exchange</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php
                    $data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();
                    echo $data->exchange;
                  ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Currency</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php
                    $data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();
                    $forex = Forex::findOne($data->forex);
                    echo $forex->currency_code.' '.number_format($data->buy_in_rate,2) ;
                   ?>
                  <?php $s['forex'].$s['buy_in_price'] ?>
                  <?php //echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>

        <!--empty space-->
        <tr>
          <td style="width:20%;padding:10px;" class="th-daily-blue"></td>
          <?php if (!empty($stocks)): ?>
            <?php foreach ($stocks as $k => $s): ?>
              <td style="text-align:center">
                <?php //echo $s['stock'] echo ''?>
                <?php echo '-' ?>
              </td>
            <?php endforeach; ?>
          <?php else: ?>
              <td style="text-align:center"></td>
          <?php endif; ?>
        </tr>
        <!--empty space-->

        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Initial Existing Shareholdings</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">

                  <?php echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Purchase Date</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php
                    $data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();
                    if (empty($data->date)) {
                      echo '-';
                    }else{
                        echo date('d M Y', strtotime($data->date));
                    }

                  ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Unit Purchase Price</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php
                    $data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();
                    echo number_format($data->buy_in_price,2);
                  ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Units</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php
                    $data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();
                    echo number_format($data->buy_units,2);
                  ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Total Purchase Price</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php
                    $data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();
                    $total = $data->buy_units*$data->buy_in_price;
                    echo number_format($total,2);
                  ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>

        <!--empty space-->
        <tr>
          <td style="width:20%;padding:10px;" class="th-daily-blue"></td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php //echo $s['stock'] echo ''?>
                  <?php echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"></td>
            <?php endif; ?>
        </tr>
        <!--empty space-->

        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Sale Date</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php
                    //$data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();
                  //  if (empty($data->sold_date)) {
                  ////    echo '-';
                  //  }else{
                  //    echo date('d M Y',strtotime($data->sold_date) );

                  //  }
                  ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Unit Price on Date of Sale</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php echo number_format($s['sold_price'],2) ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Units sold</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php //echo $s['stock'] echo ''?>
                  <?php echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Shareholdings Sold</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php //echo $s['stock'] echo ''?>
                  <?php echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
              <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>

        <!--empty space-->
        <tr>
          <td style="width:20%;padding:10px;" class="th-daily-blue"></td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php //echo $s['stock'] echo ''?>
                  <?php echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
              <td style="text-align:center"> <h4></h4></td>
            <?php endif; ?>
        </tr>
        <!--empty space-->

        <!--edrloc--->
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Unit Price @ <?php echo date('d M Y', strtotime($start_end) ) ?></td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php
                    $data = Stocks::find()->where(['product_id'=>$s['product'] ])->one();

                    $stockline = StocksLine::find()->where(['stocks_id'=>$data->id,'month'=>$start_end])->one();
                    echo number_format($stockline->month_price,2);
                  ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Units</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php //echo $s['stock'] echo ''?>
                  <?php echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td style="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Current Existing Shareholdings</td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php //echo $s['stock'] echo ''?>
                  <?php echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
                <td tyle="text-align:center"> <h4>-</h4></td>
            <?php endif; ?>
        </tr>

        <!--Empty Space--->
        <tr>
          <td style="width:20%;padding:10px;" class="th-daily-blue"></td>
            <?php if (!empty($stocks)): ?>
              <?php foreach ($stocks as $k => $s): ?>
                <td style="text-align:center">
                  <?php //echo $s['stock'] echo ''?>
                  <?php echo '-' ?>
                </td>
              <?php endforeach; ?>
            <?php else: ?>
              <td style="text-align:center"> </td>
            <?php endif; ?>
        </tr>
        <!--Empty Space--->

        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Unrealised Gain/Loss</td>
          <?php if (!empty($stocks)): ?>
            <?php foreach ($stocks as $k => $s): ?>
              <td style="text-align:center">
                <?php //echo $s['stock'] echo ''?>
                <?php echo 'USD xxx' ?>
              </td>
            <?php endforeach; ?>
          <?php else: ?>
            <td style="text-align:center">
              <?php echo 'USD xxx' ?>
            </td>
          <?php endif; ?>
        </tr>

        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white"></td>
          <?php if (!empty($stocks)): ?>
            <?php foreach ($stocks as $k => $s): ?>
              <td style="text-align:center">
                <?php //echo $s['stock'] echo ''?>
                <?php echo 'SGD xxx' ?>
              </td>
            <?php endforeach; ?>
          <?php else: ?>
            <td style="text-align:center">
              <?php echo 'SGD xxx' ?>
            </td>
          <?php endif; ?>
        </tr>

        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white"></td>
          <?php if (!empty($stocks)): ?>
            <?php foreach ($stocks as $k => $s): ?>
              <td style="text-align:center">
                <?php //echo $s['stock'] echo ''?>
                <?php echo '%' ?>
              </td>
            <?php endforeach; ?>
          <?php else: ?>
            <td style="text-align:center">
              <?php echo '%' ?>
            </td>
          <?php endif; ?>
        </tr>

        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white">Realised Gain/Loss</td>
          <?php if (!empty($stocks)): ?>
            <?php foreach ($stocks as $k => $s): ?>
              <td style="text-align:center">
                <?php //echo $s['stock'] echo ''?>
                <?php echo 'USD xxx' ?>
              </td>
            <?php endforeach; ?>
          <?php else: ?>
            <td style="text-align:center">
              <?php //echo $s['stock'] echo ''?>
              <?php echo 'USD xxx' ?>
            </td>
          <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white"></td>
          <?php if (!empty($stocks)): ?>
            <?php foreach ($stocks as $k => $s): ?>
              <td style="text-align:center">
                <?php //echo $s['stock'] echo ''?>
                <?php echo 'SGD xxx' ?>
              </td>
            <?php endforeach; ?>
          <?php else: ?>
            <td style="text-align:center">
              <?php //echo $s['stock'] echo ''?>
              <?php echo 'SGD xxx' ?>
            </td>
          <?php endif; ?>
        </tr>
        <tr>
          <td style="width:20%; text-align:center" class="th-daily-blue" style="color:white"></td>
          <?php if (!empty($stocks)): ?>
            <?php foreach ($stocks as $k => $s): ?>
              <td style="text-align:center">
                <?php //echo $s['stock'] echo ''?>
                <?php echo '%' ?>
              </td>
            <?php endforeach; ?>
          <?php else: ?>
            <td style="text-align:center">
              <?php //echo $s['stock'] echo ''?>
              <?php echo '%' ?>
            </td>
          <?php endif; ?>
        </tr>

      </tbody>
    </table>
</div>

<div class="page-break">

</div>
  <!--edr work-->
<div class="appendice-metal-figures">
  <h2>Appendix V - Commission Metals Future </h2>
  <hr>
  <table border="1"  class="metal-figures">
    <thead>
      <tr>
        <th class="th-daily">Year Month</th>
        <th class="th-daily">Monthly Returns</th>
        <th class="th-daily">Cumulative Return</th>
        <th class="th-daily">Balance</th>
        <th class="th-daily">Month Commission</th>
        <th class="th-daily">Tranche</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($dates as $key => $d): ?>
          <?php
            $inv_earn = PurchaseEarning::find()->where(['investor'=>$model->id,'re_date'=>$d['re_date'],'ptype'=>'Investor' ])->sum('customer_earn');
            $metal_per = PurchaseEarning::find()->where(['investor'=>$model->id,'re_date'=>$d['re_date'],'ptype'=>'Investor' ])->one();
            $total = PurchaseEarning::find()->where(['investor'=>$model->id,'re_date'=>$d['re_date'],'ptype'=>'Investor' ])->sum('purchase_amount');
            $comms = PurchaseEarning::find()->where(['investor'=>$model->id,'re_date'=>$d['re_date'],'ptype'=>'Investor' ])->sum('company_earn');
          ?>
        <tr>
          <td><?php echo date('M Y',strtotime($d['re_date'])) ?></td>
          <td class="rights"><?php echo '$'.number_format($inv_earn,2) ?></td>
          <td class="rights">
            <?php
             $metal = $metal_per->re_metal_per *100;
             echo number_format($metal,2).'%';
            ?>
          </td>
          <td class="rights"><?php echo '$'.number_format($total,2) ?></td>
          <td class="rights"><?php echo '$'.number_format($comms,2) ?></td>
          <td class="rights">
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


<div class="page-break">

</div>

<div class="appendice-daily">
  <h2>Appendix V - Daily Metal Prices (US$/Metric Ton)</h2>
  <hr>
  <table border="1" class="table-al">
    <thead>
      <tr>
        <th colspan ="4" class="th-title">ALUMINUM</th>
      </tr>
      <tr>
        <th class="th-daily">Date</th>
        <th class="th-daily">LME ALUMINUM CASH SETTLEMENT</th>
        <th class="th-daily">LME ALUMINUM 3-MONTH</th>
        <th class="th-daily">LME ALUMINUM 3-STOCK</th>
      </tr>
      </thead>
      <?php foreach ($al as $key => $value): ?>
        <tr>
          <td class="td-daily"><strong><?php echo $value->date ?></strong> </td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->al_cash) ?></td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->al_three_month) ?></td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->al_stocl) ?></td>
        </tr>
      <?php endforeach; ?>

  </table>
  <hr>
  <table border="1" class="table-cu">
    <thead>
      <tr>
        <th colspan ="4" class="th-title">COPPER</th>
      </tr>
      <tr>
        <th class="th-daily">Date</th>
        <th class="th-daily">LME COPPER CASH SETTLEMENT</th>
        <th class="th-daily">LME COPPER 3-MONTH</th>
        <th class="th-daily">LME COPPER 3-STOCK</th>
      </tr>
      </thead>
      <?php foreach ($cu as $key => $value): ?>
        <tr>
          <td class="td-daily"><strong><?php echo $value->date ?></strong> </td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->cu_cash) ?></td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->cu_three_month) ?></td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->cu_stock) ?></td>
        </tr>
      <?php endforeach; ?>

  </table>
<hr>
  <table border="1" class="table-au">
    <thead>
      <tr>
        <th colspan ="2" class="th-title">GOLD</th>
      </tr>
      <tr>
        <th class="th-daily">Date</th>
        <th class="th-daily">GOLD LONDON FIXING</th>
      </tr>
    </thead>
      <?php foreach ($au as $key => $value): ?>
        <tr>
          <td class="td-daily"><strong><?php echo $value->date ?></strong> </td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->au_fixing) ?></td>

        </tr>
      <?php endforeach; ?>

  </table>

  <hr>
  <table border="1" class="table-ni">
    <thead>
      <tr>
        <th colspan ="4" class="th-title">NICKEL</th>
      </tr>
      <tr>
        <th class="th-daily">Date</th>
        <th class="th-daily">LME NICKEL CASH SETTLEMENT</th>
        <th class="th-daily">LME NICKEL 3-MONTH</th>
        <th class="th-daily">LME NICKEL 3-STOCK</th>
      </tr>
    </thead>
      <?php foreach ($ni as $key => $value): ?>
        <tr>
          <td class="td-daily"><strong><?php echo $value->date ?></strong> </td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->ni_cash) ?></td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->ni_three_month) ?></td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->ni_stock) ?></td>
        </tr>
      <?php endforeach; ?>

  </table>
<hr>
  <table border="1" class="table-oil">
    <thead>
      <tr>
        <th colspan ="7" class="th-title">WTI CRUDE OIL</th>
      </tr>
      <tr>
        <th class="th-oil">Date</th>
        <th class="th-oil">PRICE</th>
        <th class="th-oil">OPEN</th>
        <th class="th-oil">HIGH</th>
        <th class="th-oil">LOW</th>
        <th class="th-oil">VOL.</th>
        <th class="th-oil">CHANGE%</th>
      </tr>
    </thead>
      <?php foreach ($oil as $key => $value): ?>
        <tr>
          <td class="td-oil"><strong><?php echo $value->date ?></strong> </td>
          <td class="td-oil"><?php echo $value->oil_price ?></td>
          <td class="td-oil"><?php echo $value->oil_open ?></td>
          <td class="td-oil"><?php echo $value->oil_high ?></td>
          <td class="td-oil"><?php echo $value->oil_low ?></td>
          <td class="td-oil"><?php echo $value->oil_volume ?></td>
          <td class="td-oil"><?php echo $value->oil_change ?></td>
        </tr>
      <?php endforeach; ?>

  </table>
  <hr>
  <table border="1" class="table-zn">
    <thead>
      <tr>
        <th colspan ="4" class="th-title">ZINC</th>
      </tr>
      <tr>
        <th class="th-daily">Date</th>
        <th class="th-daily">ZINC NICKEL CASH SETTLEMENT</th>
        <th class="th-daily">ZINC NICKEL 3-MONTH</th>
        <th class="th-daily">ZINC NICKEL 3-STOCK</th>
      </tr>
    </thead>
      <?php foreach ($zn as $key => $value): ?>
        <tr>
          <td class="td-daily"><strong><?php echo $value->date ?></strong> </td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->zn_cash) ?></td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->zn_three_month)  ?></td>
          <td class="td-daily"><?php echo Retrieve::get_numberFormat($value->zn_stock) ?></td>
        </tr>
      <?php endforeach; ?>

  </table>

</div>





<?php
$al = null;
$cu =null;
$au = null;
$ni = null;
$oil = null;
$zn = null;
$unrealised =null;
$unrealisedgain =null;
 ?>
