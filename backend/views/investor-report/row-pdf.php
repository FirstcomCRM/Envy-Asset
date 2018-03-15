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

//echo $searchModel->start;
$al = MetalAl::find()->where(['date_uploaded'=>$start])->all();
$cu = MetalCu::find()->where(['date_uploaded'=>$start])->all();
$au = MetalAu::find()->where(['date_uploaded'=>$start])->all();
$ni = MetalNi::find()->where(['date_uploaded'=>$start])->all();
$oil = MetalOil::find()->where(['date_uploaded'=>$start])->all();
$zn = MetalZn::find()->where(['date_uploaded'=>$start])->all();
$unrealised = MetalUnrealised::find()->where(['date_uploaded'=>$start])->all();
$unrealisedgain =MetalUnrealisedGain::find()->where(['date_uploaded'=>$start])->one();

$pur_metal = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Metal'])->asArray()->all();
$pur_nickel = Purchase::find()->where(['investor'=>$model->investor, 'purchase_type'=>'Nickel'])->asArray()->all();

$custom_metal_sum = 0;
$company_metal_sum = 0;

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


</style>



<div class="cover-image">

  <?php  $front = Yii::getAlias('@images').'/'.'front-page.png' ?>
  <?php  $logo = Yii::getAlias('@images').'/'.'logo.png' ?>
  <img src="<?php echo $logo ?>" alt="logo" class="front-page">
  <img src="<?php echo $front ?>" alt="Front" class="front-page">
  <div class="cover-description">
    <h1><strong>Investor Report</strong></h1>
    <h3>As of <?php echo $end ?></h3>
    <h3>Prepared by Envy Asset Management Pte Ltd</h3>
  </div>
</div>

<div class="page-break">

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
      <td class="th-daily" style="width:20%">Date</td>
      <td class="th-daily" style="width:40%">Beginning Balance</td>
      <td class="th-daily" style="width:20%"></td>
      <td class="th-daily" style="width:20%"> </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <b>Future Metal Trading</b>
      </td>
      <td></td>
      <td>
        <b>0.00</b>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <b>Securities</b>
      </td>
      <td></td>
      <td>
        <b>0.00</b>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <b>Physical Metal Trading</b>
      </td>
      <td></td>
      <td>
        <b>0.00</b>
      </td>
    </tr>

    <!--Insert Nickel deal loop here-->

      <tr>
        <td></td>
        <td><?php echo date('M Y', strtotime($model->date) ). ' Nickel Contract' ?></td>
        <td></td>
        <td><?php echo number_format($model->price,2) ?></td>
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
      <td class="th-daily" style="width:20%">Debit</td>
      <td class="th-daily" style="width:20%">Credit </td>
    </tr>


    <tr>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black">  <b>Future Metal Trading </b></td>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"> </td>
    </tr>


      <!--lopp for Purchase metal module-->
    <?php foreach ($pur_metal as $key => $value): ?>
      <?php $earning = PurchaseEarning::find()->where(['purchase_id'=>$value['id'] ])->all() ?>
        <?php foreach ($earning as $k => $v): ?>
          <tr>
            <td><?php echo date('M Y',strtotime($v['re_date']) ) ?></td>
            <td>Realised profits from Futures Metal Trading </td>
            <?php $nums = number_format($v['customer_earn'],2); ?>
            <td></td>
            <td><?php echo $nums ?></td>
            <?php $custom_metal_sum = $custom_metal_sum+$v['customer_earn']; ?>
          </tr>
          <tr>
            <td><?php echo date('M Y',strtotime($v['re_date']) ) ?></td>
            <td>Commission charged </td>
            <td><?php echo '('.number_format($v['company_earn'],2).')'; ?></td>
            <td></td>
            <?php $company_metal_sum = $company_metal_sum+$v['company_earn']; ?>
          </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <!--End lopp for Purchase metal module-->
    <!--Footer of Purchase metal---->
    <tr>
      <td></td>
      <td>Realised Profits</td>
      <td></td>
      <td style="border-top:1px solid black;border-bottom:1px solid black;"><?php echo number_format($company_metal_sum,2) ?></td>
    </tr>
    <!--End Footer of Purchase metal---->
      <!--edr-->

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
      <td style="border-bottom:1px solid black">  <b>Physical Metal Trading </b></td>
      <td style="border-bottom:1px solid black"></td>
      <td style="border-bottom:1px solid black"> </td>
    </tr>


    <!--lopp for Purchase nickel module-->
    <?php foreach ($pur_nickel as $key => $value): ?>
      <?php $n_earn = PurchaseEarning::find()->where(['purchase_id'=>$value['id'] ])->all() ?>
      <?php foreach ($n_earn as $k => $v): ?>
        <tr>
          <td><?php echo date('M Y',strtotime($v['re_date']) ) ?></td>
          <td>Realised profits from Futures Nickel Deal </td>
          <?php $nums = number_format($v['customer_earn'],2); ?>
          <td></td>
          <td><?php echo "($nums)" ?></td>
          <?php $custom_metal_sum = $custom_metal_sum+$v['customer_earn']; ?>
        </tr>
        <tr>
          <td><?php echo date('M Y',strtotime($v['re_date']) ) ?></td>
          <td>Commission charged </td>
          <td><?php echo number_format($v['company_earn'],2); ?></td>
          <td></td>
          <?php $company_metal_sum = $company_metal_sum+$v['company_earn']; ?>
        </tr>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <!--End lopp for Purchase nickel module-->
    <!--Footer of Purchase metal---->
    <tr>
      <td></td>
      <td>Realised Profits</td>
      <td></td>
      <td style="border-top:1px solid black;border-bottom:1px solid black;"><?php echo number_format($company_metal_sum,2) ?></td>
    </tr>
    <!--End Footer of Purchase metal---->

  </table>
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
      <td colspan = "2" class="td-metal-sum"><?php echo Retrieve::retrieveFormat($unrealisedgain->re_usd)?></td>
      <td colspan = "2" class="td-metal-sum">USD</td>
      <td colspan = "2" class="td-metal-sum"><?php echo Retrieve::retrieveFormat($unrealisedgain->re_usd) ?></td>
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
      <td colspan = "2" class="td-metal-sum"><?php echo Retrieve::retrieveFormat($unrealisedgain->usd) ?></td>
      <td colspan = "2" class="td-metal-sum">USD</td>
      <td colspan = "2" class="td-metal-sum"><?php echo Retrieve::retrieveFormat($unrealisedgain->sgd) ?></td>
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
