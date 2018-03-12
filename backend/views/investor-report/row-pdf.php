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
