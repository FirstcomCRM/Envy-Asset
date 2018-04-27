<?php
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
if (!empty($searchModel->start)) {
  $newDate = date('M-Y',strtotime($searchModel->start));
  $endDate = date('d M Y', strtotime($searchModel->end));
}else{
  $newDate = '';
}

$start = date('Y-m-01',strtotime($model->date) );
$end = date('Y-m-t',strtotime($model->date));

$start_search = date('Y-m-01',strtotime($searchModel->start) );
$start_end = date('Y-m-t',strtotime($searchModel->end));

$d = new \DateTime($start_search);
$d->modify('-1month');
$reduc_date_start = $d->format('Y-m-d');
$reduc_date_end = $d->format('Y-m-t');
//echo $searchModel->start;
//$al = MetalAl::find()->where(['date_uploaded'=>$start])->all();
//$cu = MetalCu::find()->where(['date_uploaded'=>$start])->all();
//$au = MetalAu::find()->where(['date_uploaded'=>$start])->all();
//$ni = MetalNi::find()->where(['date_uploaded'=>$start])->all();
//$oil = MetalOil::find()->where(['date_uploaded'=>$start])->all();
//$zn = MetalZn::find()->where(['date_uploaded'=>$start])->all();

$al = MetalAl::find()->where(['date_uploaded'=>$start_search])->all();
$cu = MetalCu::find()->where(['date_uploaded'=>$start_search])->all();
$au = MetalAu::find()->where(['date_uploaded'=>$start_search])->all();
$ni = MetalNi::find()->where(['date_uploaded'=>$start_search])->all();
$oil = MetalOil::find()->where(['date_uploaded'=>$start_search])->all();
$zn = MetalZn::find()->where(['date_uploaded'=>$start_search])->all();

//$al = MetalAl::find()->where(['between','date_filter',$start,$end])->all();
//$cu = MetalCu::find()->where(['date_uploaded'=>$start])->all();
//$au = MetalAu::find()->where(['date_uploaded'=>$start])->all();
//$ni = MetalNi::find()->where(['date_uploaded'=>$start])->all();
//$oil = MetalOil::find()->where(['date_uploaded'=>$start])->all();
//$zn = MetalZn::find()->where(['date_uploaded'=>$start])->all();

$unrealised = MetalUnrealised::find()->where(['date_uploaded'=>$start])->all();
$unrealisedgain =MetalUnrealisedGain::find()->where(['date_uploaded'=>$start])->one();

$pur_metal = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Metal'])->asArray()->all();
//$pur_metal = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Metal'])->andFilterWhere(['between','date',$searchModel->start,$searchModel->end])->asArray()->all();

$pur_nickel = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Nickel'])->asArray()->all();
$pur_nickel_a = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Nickel'])
        ->andFilterWhere(['<=','date',$start_search])
        ->andFilterwhere(['>=','expiry_date',$start_end])
        ->asArray()
        ->all();
/*
$query->andFilterwhere(['<=','date',$this->start])
      ->andFilterwhere(['>=','expiry_date',$this->end])
*/

$pur_nickel_sum = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Nickel'])
    ->andFilterWhere(['<=','date',$start_search])
    ->andFilterwhere(['>=','expiry_date',$start_end])
    ->sum('price');

$metals = Withdraw::find()->where(['between','date',$start_search,$start_end])->andFilterWhere(['investor'=>$model->investor,'product_type'=>2])->asArray()->all();
$nickels = Withdraw::find()->where(['between','date',$start_search,$start_end ])->andFilterWhere(['investor'=>$model->investor,'product_type'=>3])->asArray()->all();

//$stocks = Stocks::find()->where(['between','date',$start_search,$start_end])->asArray()->limit(3)->all();
$stocks = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Stocks'])->asArray()->limit(3)->all();
//$pur_nickel = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Nickel'])->asArray()->all();

$inv = Investor::find()->where(['id'=>$model->investor])->one();

$dates = PurchaseEarning::find()->select(['re_date'])->where(['investor'=>$model->investor])->distinct()->asArray()->all();
//$fmt_trade = PurchaseEarning::find()->where(['investor'=>$model->investor, 're_date'=>$reduc_date_start])->asArray()->all();
$fmt_trade_sum = PurchaseEarning::find()->where(['investor'=>$model->investor, 're_date'=>$reduc_date_start])->sum('customer_earn_after');


$withdraw_metal = 0;
$withdraw_nickel = 0;

$custom_metal_sum = 0;
$company_metal_sum = 0;

$fmt = 0;
$fmt_diff = 0;
$pmt = 0;
$bb = [];

//Under Beginning balance execute looping for future meta trading(metal), securities and Phyiscal Metal Trading(nickel)
/*foreach ($fmt_trade as $k => $v) {
  $bb[] = $v['customer_earn_after'];
}*/



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
  }

  .th-title{
    background-color:#002041;
    color: #FFD839;
    padding: 5px;
  }

  .th-daily-blue{
    background-color:#002041;
    color:#C7AF3E;
    font-weight:bold;
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
  <pre>
    <?php print_r($fmt_trade)  ?>
  </pre>
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

  <table border="0" class="table-breakdown">
    <tr>
      <td  style="width:20%"></td>
      <td  style="width:40%"></td>
      <td  style="width:20%"></td>
      <td class="rights" style="width:20%"><strong>SGD</strong> </td>
    </tr>
    <tr>
      <td class="th-daily" style="width:20%">Date</td>
      <td class="th-daily" style="width:40%">Beginning Balance as at <?php echo $d->format('t M Y'); ?></td>
      <td class="th-daily" style="width:20%"></td>
      <td class="th-daily rights" style="width:20%"><?php echo number_format( ($fmt_trade_sum+$model->price),2) ?> </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <b>Future Metal Trading</b>
      </td>
      <td></td>
      <td class="rights">
        <b><?php echo number_format($fmt_trade_sum)  ?></b>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <b>Securities</b>
      </td>
      <td></td>
      <td class="rights">
        <b>0.00</b>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <b>Physical Metal Trading</b>
      </td>
      <td></td>
      <td class="rights">
        <b>0.00</b>
      </td>
    </tr>

    <!--Insert Nickel deal loop here-->

      <tr>
        <td></td>
        <td><?php echo date('M Y', strtotime($start_search) ). ' Nickel Contract' ?></td>
        <td></td>
        <td class="rights"><?php echo number_format($model->price,2) ?></td>
      </tr>


    <!--End of Nickel deal loop here-->

    <tr>
      <td style="padding:10px"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td style="padding:10px"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="th-daily" style="width:20%"></td>
      <td class="th-daily" style="width:40%">Transactions during the month</td>
      <td class="th-daily rights"  style="width:20%">Debit</td>
      <td class="th-daily rights"  style="width:20%">Credit </td>
    </tr>


    <tr>
      <td style="border-bottom:1px solid black"></td>
      <!--metal type--->
      <td style="border-bottom:1px solid black"><b>Future Metal Trading </b></td>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"> </td>
    </tr>


      <!--lopp for Purchase metal module-->
    <?php foreach ($pur_metal as $key => $value): ?>
      <?php $earning = PurchaseEarning::find()->where(['purchase_id'=>$value['id'],'re_date'=>$start_search ])->all() ?>
        <?php foreach ($earning as $k => $v): ?>
          <tr>
            <td><?php echo date('d M Y',strtotime($v['re_date']) ) ?></td>
            <td>Realised profits from Futures Metal Trading </td>
            <?php $nums = number_format($v['customer_earn'],2); ?>
            <td></td>
            <td class="rights"><?php echo $nums ?></td>
            <?php $custom_metal_sum = $custom_metal_sum+$v['customer_earn']; ?>
          </tr>
          <tr>
            <td><?php echo date('d M Y',strtotime($v['re_date']) ) ?></td>
            <td>Commission charged </td>
            <td class="rights"><?php echo '('.number_format($v['company_earn'],2).')'; ?></td>
            <td></td>
            <?php $company_metal_sum = $company_metal_sum+$v['company_earn']; ?>
            <?php $fmt =  $custom_metal_sum - $company_metal_sum?>
          </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <!--End lopp for Purchase metal module-->
    <!--Footer of Purchase metal---->
    <tr>
      <td></td>
      <td>Realised Profits</td>
      <td> </td>
      <td class="rights" style="border-top:1px solid black;border-bottom:1px solid black;"><strong> <?php echo number_format($fmt,2) ?></strong></td>
    </tr>
    <!--End Footer of Purchase metal---->
      <!--edr-->
    <tr>
      <td style="padding:10px"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>

    <!--Withdraw metal start--->
    <tr>
      <td style="padding:10px"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>

    <?php foreach ($metals as $key => $value): ?>
      <tr>
        <td><?php echo date('d M Y', strtotime($value['date'])) ?></td>
        <td><?php echo $value['description'] ?> </td>
        <td class="rights">
          <?php $nums = number_format($value['price'],2);
            echo '('.$nums.')';
          ?>
          <?php
            $withdraw_metal +=$value['price']
          ?>
        </td>
        <td></td>
      </tr>
    <?php endforeach; ?>

    <!---//metal footer commented out due to on being credit side?--->
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td class="rights" style="border-top:1px solid black;border-bottom:1px solid black;">
        <strong>
          <?php
            $fmt_diff = $fmt-$withdraw_metal;
            echo number_format($fmt_diff,2)
          ?>
        </strong>
      </td>
    </tr>

    <!--Withdraw metal end--->

    <tr>
      <td style="padding:10px"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>

    <?php $custom_metal_sum = 0;
        $company_metal_sum = 0;
    ?>

    <tr>
      <td style="border-bottom:1px solid black"></td>
        <!--Nickel type--->
      <td style="border-bottom:1px solid black"><b>Physical Metal Trading</b></td>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"> </td>
    </tr>


    <!--lopp for Purchase nickel module-->
    <?php foreach ($pur_nickel as $key => $value): ?>
      <?php $n_earn = PurchaseEarning::find()->where(['purchase_id'=>$value['id'],'re_date'=>$start_search ])->asArray()->all() ?>
      <?php foreach ($n_earn as $k => $v): ?>
        <tr>
          <td><?php echo date('d M Y',strtotime($v['re_date']) ) ?></td>
          <td>Realised profits from Futures Nickel Deal </td>
          <?php $nums = number_format($v['customer_earn'],2); ?>
          <td></td>
          <td class="rights"><?php echo "($nums)" ?></td>
          <?php $custom_metal_sum = $custom_metal_sum+$v['customer_earn']; ?>
        </tr>
        <tr>
          <td><?php echo date('d M Y',strtotime($v['re_date']) ) ?></td>
          <td>Commission charged </td>
          <td class="rights"><?php echo number_format($v['company_earn'],2); ?></td>
          <td></td>
          <?php $company_metal_sum = $company_metal_sum+$v['company_earn']; ?>
          <?php $pmt = $custom_metal_sum -  $company_metal_sum?>
        </tr>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <!--End lopp for Purchase nickel module-->
    <!--Footer of Purchase metal---->
    <tr>
      <td></td>
      <td>Realised Profits</td>
      <td></td>
      <td class="rights" style="border-top:1px solid black;border-bottom:1px solid black;"><strong> <?php echo number_format($pmt,2) ?></strong></td>
    </tr>
    <!--End Footer of Purchase metal---->

    <!--Withdraw metal start--->
    <tr>
      <td style="padding:10px"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>

    <?php foreach ($nickels as $key => $value): ?>
      <tr>
        <td><?php echo date('d M Y', strtotime($value['date'])) ?></td>
        <td><?php echo $value['description'] ?>l</td>
        <td class="rights">
          <?php $nums = number_format($value['price'],2);
            echo '('.$nums.')';
          ?>
          <?php
            $withdraw_nickel +=$value['price']
          ?>
        </td>
        <td></td>
      </tr>
    <?php endforeach; ?>

    <!----//metal footer commented out due to on being credit side?--->
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td class="rights" style="border-top:1px solid black;border-bottom:1px solid black;"><strong><?php echo number_format($withdraw_nickel,2) ?></strong> </td>
    </tr>

    <!--Withdraw metal end--->


  </table>

  <br>

  <hr>
<table border="0" class="table-ending">
  <thead>
    <tr>
      <td class="th-daily" style="width:20%">Date</td>
      <td class="th-daily" style="width:30%">Ending Balance as of <?php echo $endDate ?></td>
      <td class="th-daily" style="width:20%"></td>
      <td class="th-daily" style="width:20%"></td><!--Numeric Value Here--->
      <td class="th-daily" style="width:10%" ></td><!--Percentage Something---->
    </tr>
  </thead>
    <tr>
      <td style="padding:10px"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td style="border-bottom:1px solid black;"></td><!--here-->
      <td style="border-bottom:1px solid black;"><strong>Physical Metal Trading</strong> </td>
      <td style="border-bottom:1px solid black;"></td>
      <td class="rights" style="border-bottom:1px solid black;"><strong><?php echo number_format($pur_nickel_sum,2)  ?></strong> </td><!---ssss--->
      <td style="border-bottom:1px solid black;"></td>
    </tr>
    <tbody>
      <!---edr loc--->
        <?php foreach ($pur_nickel_a as $key => $value): ?>
          <tr>
            <td></td>
            <td>
              <?php
                $date = new \DateTime($value['date']);
                echo $date->format('d M Y').' Nickel Contract';
               ?>
            </td>
            <td> <?php echo $value['date'] ?></td>
            <td class="rights"><?php echo number_format($value['price'],2) ?></td>
            <td></td>
          </tr>

      <?php endforeach; ?>
    </tbody>
</table>

  <br>
  <!--edr start 3rd table of appendix 1--->
  <table border="0" class="table-others">
    <thead>
      <tr>
        <td class="th-daily-blue">Description of Contract Entered</td>
        <td class="th-daily-blue">SGD</td>
        <td class="th-daily-blue">Maturity of Lock-In Capital</td>
      </tr>
    </thead>
      <tbody>
          <?php foreach ($pur_nickel_a as $key => $value): ?>
            <tr>
              <td>
                <?php
                  $date = new \DateTime($value['date']);
                  echo $date->format('d M Y').' Nickel Contract';
                 ?>
              </td>
              <td class="rights"><?php echo number_format($value['price'],2) ?></td>
              <td>
                <?php
                  $date = new \DateTime($value['date']);
                  $start = $date->format('d M Y');
                  $date = new \DateTime($value['expiry_date']);
                  $end = $date->format('d M Y');
                  echo $start.' - '.$end;
                 ?>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>

  </table>
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
            $inv_earn = PurchaseEarning::find()->where(['investor'=>$model->investor,'re_date'=>$d['re_date'] ])->sum('customer_earn');
            $metal_per = PurchaseEarning::find()->where(['investor'=>$model->investor,'re_date'=>$d['re_date'] ])->one();
            $total = PurchaseEarning::find()->where(['investor'=>$model->investor,'re_date'=>$d['re_date'] ])->sum('purchase_amount');
            $comms = PurchaseEarning::find()->where(['investor'=>$model->investor,'re_date'=>$d['re_date'] ])->sum('company_earn');
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
