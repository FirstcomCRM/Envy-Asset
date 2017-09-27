<?php
use common\components\Retrieve;

?>

<?php
if (!empty($searchModel->start)) {
  $newDate = date('M-Y',strtotime($searchModel->start));
}else{
  $newData = '';
}

 ?>
<style>
  .head{
    margin-bottom: 15px;
  }

  .page-break{
    page-break-after: always;
  }

  .cover-image{
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
    <h3>As of <?php echo $endDate ?></h3>
    <h3>Prepared by Envy Asset Management Pte Ltd</h3>
  </div>
</div>


<div class="page-break">

</div>

<div class="head">
  Investor Report for : <?php echo $newDate ?>
</div>

<table class="investor-report" border='1'>
  <thead>
    <tr>
      <th class="investor-td">Investor</th>
      <th class="investor-td">Product</th>
      <th class="investor-td">Share</th>
      <th class="investor-td">Price</th>
      <th class="investor-td">Date</th>
      <th class="investor-td">Sales Person</th>
      <th class="investor-td">Remarks</th>
    </tr>
  </thead>
  <?php foreach ($dataProvider->getModels() as $key => $value): ?>
    <tr>
      <td class="investor-td"><?php echo Retrieve::retrieveInvestor($value->investor) ?></td>
      <td class="investor-td"><?php echo Retrieve::retrieveProductName($value->product) ?></td>
      <td class="investor-td"><?php echo $value->share ?></td>
      <td class="investor-td"><?php echo $value->price ?></td>
      <td class="investor-td"><?php echo $value->date ?></td>
      <td class="investor-td"><?php echo Retrieve::retrieveUsernameManagement($value->salesperson) ?></td>
      <td class="investor-td"><?php echo nl2br($value->remarks) ?></td>
    </tr>
  <?php endforeach; ?>

</table>
