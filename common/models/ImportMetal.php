<?php

namespace common\models;

use Yii;
use common\models\MetalAl;
use common\models\MetalCu;
use common\models\MetalNi;
use common\models\MetalZn;
use common\models\MetalAu;
use common\models\MetalOil;
use common\models\MetalUnrealised;
use common\models\MetalUnrealisedGain;
use common\models\MetalNickelDeals;
use common\models\PurchaseEarning;
use common\models\Purchase;
use common\models\ProductManagement;
/**
 * This is the model class for table "import_metal".
 *
 * @property integer $id
 * @property string $date_file
 * @property string $file_name
 */
class ImportMetal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;

    public static function tableName()
    {
        return 'import_metal';
    }

    public function behaviors()
     {
      return [
        'sammaye\audittrail\LoggableBehavior'
      ];
     }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_file'], 'required'],
            [['date_file','date_added'], 'safe'],
            [['remarks'],'string'],
            [['file_name'], 'string', 'max' => 75],
            [['file'],'file','skipOnEmpty'=>false, 'mimeTypes'=>'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
               'wrongMimeType'=>'Invalid file format. Please use .xls or .xlsx',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_file' => 'Date',
            'file_name' => 'File Name',
            'file'=>'Import File',
        ];
    }

    public function upload(){
      $filename =  time().$this->file;
      $this->file->saveAs(Yii::getAlias('@metal').'/'.$filename);
      $this->file_name = $this->file->baseName.'.'.$this->file->extension;
      return $filename;
    }

    public function importBase($filename){
      $inputFile = Yii::getAlias('@metal').'/'.$filename;
//      $inputFile = Yii::getAlias('@metal').'/'.'1502272349May 2017.xlsx';
    try {
      $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
      $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($inputFile);
    } catch (Exception $e) {
      die('Error');
    }

    $sheet = $objPHPExcel->getSheet(0);//sheet commodities
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();


    $metal_un = [
      'au'=>'Gold (unrealised)',
      'ni'=>'Nickel (unrealised)',
      'al'=>'Aluminium (unrealised)',
      'zn'=>'Zinc (unrealised)',
      'cu'=>'Copper (unrealised)',
      'un'=>'Unrealised gain/(loss)',
      're'=>'Realised gain/(loss)',
    ];

    $true_date = null;
    $multiplier = null;
    $ammo = 0;

    $mdate = new \DateTime($this->date_file);
  //  $mdate->modify('-1month');
    $true_date = $mdate->format('Y-m-d');

      for ($row=5; $row<=$highestRow ; $row++) {
        $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        $node = array_search($rowData[0][0],$metal_un);
        if (!empty($node) && ($node != 're' && $node != 'un')) {
          $metal = new MetalUnrealised();
          $metal->import_metal_id = $this->id;
      //    $metal->date_uploaded =date('Y-m-d',strtotime($this->date_file) ) ;
          $metal->date_uploaded =$true_date ;
          $metal->commodity = $rowData[0][0];
          $metal->position = $rowData[0][1];
          $metal->entry_date_usd = date($format = "Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][2]));
          $metal->entry_price_usd = $rowData[0][3];
          $metal->entry_value_usd = $rowData[0][4];
          $metal->exit_date_usd = date($format = "Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][6]));
          $metal->exit_price_usd = $rowData[0][7];
          $metal->exit_value_usd = $rowData[0][8];
          $metal->realised_gain_usd = $rowData[0][10];
          $metal->realised_gain_percent = (float)$rowData[0][11];
          $metal->profit_lost_usd = $rowData[0][12];
          $metal->profit_lost_sgd = $rowData[0][13];
          $metal->save(false);
        }elseif ($node == 're' || $node=='un' || $ammo != 0) {
          if ($node == 're') {
            $gain = new MetalUnrealisedGain();
            $gain->date_uploaded = $this->date_file;
      //      $gain->true_date = $this->date_file;
            //edr
          //  $mdate = new \DateTime($this->date_file);
        //    $mdate->modify('-1month');
        //    $gain->true_date = $mdate->format('Y-m-d');
        //    $true_date = $gain->true_date;
            $gain->true_date = $true_date;

            $gain->import_metal_id = $this->id;
            $gain->re_description = $rowData[0][0];
            $gain->re_usd = $rowData[0][1];
            $gain->re_sgd = $rowData[0][3];
            $gain->save(false);
        //    $ammo = 1;
          }elseif($node == 'un'){
            $update = MetalUnrealisedGain::find()->where(['import_metal_id'=>$this->id])->one();
            $update->description = $rowData[0][0];
            $update->usd = $rowData[0][1];
            $update->sgd = $rowData[0][3];
            $update->save(false);

          }elseif ($ammo == 1) { //update re_gain_loss at $node == re
            $update = MetalUnrealisedGain::find()->where(['import_metal_id'=>$this->id])->one();
            $update->re_gain_loss = $rowData[0][3];
            $multiplier = $update->re_gain_loss;
            $update->save(false);
        //    $ammo =2;
          }elseif ($ammo == 4) {//update gain_loss at $node == un
            $update = MetalUnrealisedGain::find()->where(['import_metal_id'=>$this->id])->one();
            $update->gain_loss = $rowData[0][3];
          //  print_r( $rowData[0][3]);die();
            $update->save(false);
          }
          $ammo++;
        } else{
          continue;
        }
      }


      //insert here for the purchase update edrs
      $data = PurchaseEarning::find()->where(['re_date'=>$true_date])->all();
      $ids = null;

      if (!empty($data) ) {
        foreach ($data as $key => $value) {
          $purs = Purchase::find()->where(['id'=>$value->purchase_id])->one();
          if ($purs->charge_type == 'Others' && $purs->purchase_type == 'Metal') {
              $value->customer_earn =  $value->purchase_amount*$multiplier;
              $value->re_metal_per = $multiplier;
              $value->company_earn = $value->customer_earn * $purs->company_charge;
              $value->staff_earn = $value->company_earn/2;
              $value->save(false);

              $customer_sum = PurchaseEarning::find()->where(['purchase_id'=>$value->purchase_id])->sum('customer_earn');
              $company_sum = PurchaseEarning::find()->where(['purchase_id'=>$value->purchase_id])->sum('company_earn');
              $staff_sum = PurchaseEarning::find()->where(['purchase_id'=>$value->purchase_id])->sum('staff_earn');

              $purs->customer_earn = $customer_sum;
              $purs->company_earn = $company_sum;
              $purs->staff_earn = $staff_sum;
              $purs->save(false);
          }
        }

      }



      //insert here
      $sheet = $objPHPExcel->getSheet(1);//daily metal prices
      $highestRow = $sheet->getHighestRow();
    //  print_r($highestRow);die();
      $highestColumn = $sheet->getHighestColumn();
      $nrow = 0;

    /*  $mdate = new \DateTime($this->date_file);
      $mdate->modify('-1month');
      $gain->true_date = $mdate->format('Y-m-d');
      $true_date = $gain->true_date;
      */

      for ($row=3; $row < $highestRow; $row++) {
         $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

         if ($rowData[0][0]=="Date" or $rowData[0][0]=="Aluminium") {
           continue;
         }

         $al = new MetalAl();
         $al->import_metal_id = $this->id;
      //   $al->date_uploaded = $this->date_file;
         $al->date_uploaded = $true_date;
         $al->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
         $al->date = str_replace(".", "", $rowData[0][0]);
         $al->al_cash = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));
         $al->al_three_month = (float)str_replace(',','.',str_replace('.','',$rowData[0][2]));
         $al->al_stocl = (float)str_replace(',','.',str_replace('.','',$rowData[0][3]));

         if (empty($rowData[0][0])) {
           $nrow = $row+1;
           break;
         }

         $al->save(false);

      }

    //  for ($row=26; $row < $highestRow; $row++) {
      for ($row = $nrow; $row <= $highestRow; $row++) {
        $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Copper") {
          continue;
        }

        $cu = new MetalCu();
        $cu->import_metal_id = $this->id;
    //    $cu->date_uploaded = $this->date_file;
        $cu->date_uploaded = $true_date;
        $cu->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $cu->date = str_replace(".", "", $rowData[0][0]);
        $cu->cu_cash = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));
        $cu->cu_three_month = (float)str_replace(',','.',str_replace('.','',$rowData[0][2]));
        $cu->cu_stock = (float)str_replace(',','.',str_replace('.','',$rowData[0][3]));
        $cu->save(false);

        if (empty($rowData[0][0])) {
          break;
        }

      }

      for ($row=3; $row <$highestRow ; $row++) {
        $rowData = $sheet->rangeToArray('F'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Nickel") {
          continue;
        }

        $ni = new MetalNi();
        $ni->import_metal_id = $this->id;
      //  $ni->date_uploaded = $this->date_file;
        $ni->date_uploaded = $true_date;
        $ni->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $ni->date = str_replace(".", "", $rowData[0][0]);
        $ni->ni_cash = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));
        $ni->ni_three_month = (float)str_replace(',','.',str_replace('.','',$rowData[0][2]));
        $ni->ni_stock = (float)str_replace(',','.',str_replace('.','',$rowData[0][3]));

        if (empty($rowData[0][0])) {
          $nrow = $row+1;
          break;
        }
        $ni->save(false);

      }

    //  for ($row=26; $row <$highestRow ; $row++) {
        for ($row = $nrow; $row <= $highestRow; $row++) {
          $rowData = $sheet->rangeToArray('F'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
          if ($rowData[0][0]=="Date" or $rowData[0][0]=="Zinc") {
            continue;
          }

          $zn = new MetalZn();
          $zn->import_metal_id = $this->id;
        //  $zn->date_uploaded = $this->date_file;
          $zn->date_uploaded = $true_date;
          $zn->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
          $zn->date = str_replace(".", "", $rowData[0][0]);
          $zn->zn_cash = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));
          $zn->zn_three_month = (float)str_replace(',','.',str_replace('.','',$rowData[0][2]));
          $zn->zn_stock = (float)str_replace(',','.',str_replace('.','',$rowData[0][3]));

          if (empty($rowData[0][0])) {
            break;
          }

          $zn->save(false);

      }

      for ($row=3; $row < $highestRow; $row++) {
        $rowData = $sheet->rangeToArray('K'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Gold") {
          continue;
        }

        $au = new MetalAu();
        $au->import_metal_id = $this->id;
      //  $au->date_uploaded = $this->date_file;
        $au->date_uploaded = $true_date;
        $au->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $au->date = str_replace(".", "", $rowData[0][0]);
        $au->au_fixing = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));

        if (empty($rowData[0][0])) {
          $nrow = $row+1;
          break;
        }
        $au->save(false);
      }

      for ($row=$nrow; $row<=$highestRow; $row++) {
        $rowData = $sheet->rangeToArray('K'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="WTI Crude Oil") {
         continue;
        }

        $oil = new MetalOil();
        $oil->import_metal_id = $this->id;
    //    $oil->date_uploaded = $this->date_file;
        $oil->date_uploaded = $true_date  ;
        $oil->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $oil->date = str_replace(",", "", $rowData[0][0]);
        $oil->oil_price = $rowData[0][1];
        $oil->oil_open = $rowData[0][2];
        $oil->oil_high = $rowData[0][3];
        $oil->oil_low = $rowData[0][4];
        $oil->oil_change = $rowData[0][6];

        $oil->oil_volume = (string)$rowData[0][5];

        if (empty($rowData[0][0])) {
          break;
        }
        $oil->save(false);
      }

    }

    public function importNickel($filename){//edr
      $inputFile = Yii::getAlias('@metal').'/'.$filename;
//      $inputFile = Yii::getAlias('@metal').'/'.'1502272349May 2017.xlsx';
    try {
      $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
      $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($inputFile);
    } catch (Exception $e) {
      die('Error');
    }
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $testarr = [];
  //  print_r($highestRow);
  //  die('start import here');

    for ($row=3; $row<=$highestRow ; $row++) {

      $data = $sheet->getCell('B'.$row)->getCalculatedValue();
      if (!empty($data)) {
          $testarr[] =  $data;
        }

    }
  //  echo '<pre>';
  //  print_r($testarr);die();
    $start = 0;
    $end = 0;

    $title = $sheet->getCell('A'.'3')->getCalculatedValue();
    $deals = new MetalNickelDeals();
    $deals->import_metal_id = $this->id;
    $deals->date_uploaded = $this->date_file;
    $deals->title = $title;
    $deals->description = $testarr[0];
    $deals->total_deal_size = $testarr[1];
    $deals->contract_period = $testarr[2];
    $deals->purchase_price_a = $testarr[3];
    $deals->insurance_cost_a = $testarr[4];
    $deals->forward_price = $testarr[6];
    $deals->final_sales_price = $testarr[7];
    $deals->purchase_price_b  = $testarr[8];
    $deals->insurance_cost_b = $testarr[9];
    $deals->total_cost_price = $testarr[10];
    $deals->unrealised_profit_a = $testarr[11];
    $deals->commision =  $testarr[12];
    $deals->unrealised_profit_b = $testarr[13];
    $deals->net_unrealised = $testarr[14];

    list($start,$end) = explode(' - ', $testarr[2]);
    $date = new \DateTime($start);
    $deals->contract_period_start = $date->format('Y-m-d');
    $date = new \DateTime($end);
    $deals->contract_period_end = $date->format('Y-m-d');

    $deals->save(false);
    $prods = new ProductManagement();
    $prods->addProduct($this->remarks);
    unset($testarr);
  //  $title = $sheet->getCell('A'.'3')->getCalculatedValue();
  //  print_r($title);die(); //edr


    }

    public function importExcel($filename){
        $inputFile = Yii::getAlias('@metal').'/'.$filename;
  //      $inputFile = Yii::getAlias('@metal').'/'.'1502272349May 2017.xlsx';
      try {
        $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFile);
      } catch (Exception $e) {
        die('Error');
      }
      $sheet = $objPHPExcel->getSheet(3);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();


      for ($row=3; $row < $highestRow; $row++) {
         $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

         if ($rowData[0][0]=="Date" or $rowData[0][0]=="Aluminium") {
           continue;
         }

         $al = new MetalAl();
         $al->import_metal_id = $this->id;
         $al->date_uploaded = $this->date_file;
         $al->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
         $al->date = str_replace(".", "", $rowData[0][0]);
         $al->al_cash = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));
         $al->al_three_month = (float)str_replace(',','.',str_replace('.','',$rowData[0][2]));
         $al->al_stocl = (float)str_replace(',','.',str_replace('.','',$rowData[0][3]));

         if (empty($rowData[0][0])) {
           break;
         }

         $al->save(false);

      }

      for ($row=26; $row < $highestRow; $row++) {
        $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Copper") {
          continue;
        }

        $cu = new MetalCu();
        $cu->import_metal_id = $this->id;
        $cu->date_uploaded = $this->date_file;
        $cu->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $cu->date = str_replace(".", "", $rowData[0][0]);
        $cu->cu_cash = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));
        $cu->cu_three_month = (float)str_replace(',','.',str_replace('.','',$rowData[0][2]));
        $cu->cu_stock = (float)str_replace(',','.',str_replace('.','',$rowData[0][3]));
        $cu->save(false);

        if (empty($rowData[0][0])) {
          break;
        }

      }

      for ($row=3; $row <$highestRow ; $row++) {
        $rowData = $sheet->rangeToArray('F'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Nickel") {
          continue;
        }

        $ni = new MetalNi();
        $ni->import_metal_id = $this->id;
        $ni->date_uploaded = $this->date_file;
        $ni->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $ni->date = str_replace(".", "", $rowData[0][0]);
        $ni->ni_cash = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));
        $ni->ni_three_month = (float)str_replace(',','.',str_replace('.','',$rowData[0][2]));
        $ni->ni_stock = (float)str_replace(',','.',str_replace('.','',$rowData[0][3]));

        if (empty($rowData[0][0])) {
          break;
        }
        $ni->save(false);

      }

      for ($row=26; $row <$highestRow ; $row++) {
        $rowData = $sheet->rangeToArray('F'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Zinc") {
          continue;
        }

        $zn = new MetalZn();
        $zn->import_metal_id = $this->id;
        $zn->date_uploaded = $this->date_file;
        $zn->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $zn->date = str_replace(".", "", $rowData[0][0]);
        $zn->zn_cash = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));
        $zn->zn_three_month = (float)str_replace(',','.',str_replace('.','',$rowData[0][2]));
        $zn->zn_stock = (float)str_replace(',','.',str_replace('.','',$rowData[0][3]));
        $zn->save(false);

        if (empty($rowData[0][0])) {
          break;
        }


      }

      for ($row=3; $row < $highestRow; $row++) {
        $rowData = $sheet->rangeToArray('K'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Gold") {
          continue;
        }

        $au = new MetalAu();
        $au->import_metal_id = $this->id;
        $au->date_uploaded = $this->date_file;
        $au->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $au->date = str_replace(".", "", $rowData[0][0]);
        $au->au_fixing = (float)str_replace(',','.',str_replace('.','',$rowData[0][1]));

        if (empty($rowData[0][0])) {
          break;
        }
        $au->save(false);
      }

      for ($row=26; $row<=$highestRow; $row++) {
        $rowData = $sheet->rangeToArray('K'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="WTI Crude Oil") {
         continue;
        }

        $oil = new MetalOil();
        $oil->import_metal_id = $this->id;
        $oil->date_uploaded = $this->date_file;
        $oil->date_filter = date("Y-m-d",strtotime($rowData[0][0]));
        $oil->date = str_replace(",", "", $rowData[0][0]);
        $oil->oil_price = $rowData[0][1];
        $oil->oil_open = $rowData[0][2];
        $oil->oil_high = $rowData[0][3];
        $oil->oil_low = $rowData[0][4];
        $oil->oil_change = $rowData[0][6];

        $oil->oil_volume = (string)$rowData[0][5];

        if (empty($rowData[0][0])) {
          break;
        }
        $oil->save(false);
      }


        //
      $sheet = $objPHPExcel->getSheet(2);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();

      $metal_un = [
        'au'=>'Gold (unrealised)',
        'ni'=>'Nickel (unrealised)',
        'al'=>'Aluminium (unrealised)',
        'zn'=>'Zinc (unrealised)',
        'cu'=>'Copper (unrealised)',
        'un'=>'Unrealised gain/(loss)',
        're'=>'Realised gain/(loss)',
      ];
      $ammo = 0;
        for ($row=5; $row<=$highestRow ; $row++) {
          $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
          $node = array_search($rowData[0][0],$metal_un);
          if (!empty($node) && ($node != 're' && $node != 'un')) {
            $metal = new MetalUnrealised();
            $metal->import_metal_id = $this->id;
            $metal->date_uploaded = $this->date_file;
            $metal->commodity = $rowData[0][0];
            $metal->position = $rowData[0][1];
            $metal->entry_date_usd = date($format = "Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][2]));
            $metal->entry_price_usd = $rowData[0][3];
            $metal->entry_value_usd = $rowData[0][4];
            $metal->exit_date_usd = date($format = "Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][6]));
            $metal->exit_price_usd = $rowData[0][7];
            $metal->exit_value_usd = $rowData[0][8];
            $metal->realised_gain_usd = $rowData[0][10];
            $metal->realised_gain_percent = (float)$rowData[0][11];
            $metal->profit_lost_usd = $rowData[0][12];
            $metal->profit_lost_sgd = $rowData[0][13];
            $metal->save(false);
          }elseif ($node == 're' || $node=='un' || $ammo != 0) {
            if ($node == 're') {
              $gain = new MetalUnrealisedGain();
              $gain->date_uploaded = $this->date_file;
              $gain->import_metal_id = $this->id;
              $gain->re_description = $rowData[0][0];
              $gain->re_usd = $rowData[0][1];
              $gain->re_sgd = $rowData[0][3];
              $gain->save(false);
              $ammo = 1;
            }elseif($node == 'un'){
              $update = MetalUnrealisedGain::find()->where(['import_metal_id'=>$this->id])->one();
              $update->description = $rowData[0][0];
              $update->usd = $rowData[0][1];
              $update->sgd = $rowData[0][3];
              $update->save(false);

            }elseif ($ammo == 1) { //update re_gain_loss at $node == re
              $update = MetalUnrealisedGain::find()->where(['import_metal_id'=>$this->id])->one();
              $update->re_gain_loss = $rowData[0][3];
              $update->save(false);
              $ammo =2;
            }elseif ($ammo === 2) {//update gain_loss at $node == un
              $update = MetalUnrealisedGain::find()->where(['import_metal_id'=>$this->id])->one();
              $update->gain_loss = $rowData[0][3];
              $update->save(false);
            }
          //  $ammo++;
          } else{
            continue;
          }
        }


      //insert nickel deal here
  //    $sheet = $objPHPExcel->getSheet(1);
      $worksheet = $objPHPExcel->getSheet(1); //nickel deal
      $highestRow = $worksheet->getHighestRow();
      $highestColumn = $worksheet->getHighestColumn();
      $testarr = [];

      $column_int = \PHPExcel_Cell::columnIndexFromString($worksheet->getHighestDataColumn());

      $column_int_a = $column_int - 3; //get title
      $column_letter = \PHPExcel_Cell::stringFromColumnIndex($column_int_a);
      $testarr [] = $worksheet->getCell($column_letter.'3')->getCalculatedValue();

      $column_int_b = $column_int - 2; //get data
      $column_letter = \PHPExcel_Cell::stringFromColumnIndex($column_int_b);

      for ($row=3; $row<=$highestRow ; $row++) {
        $data = $worksheet->getCell($column_letter.$row)->getCalculatedValue();
        if (!empty($data)) {
          $testarr[] =  $data;
        }
      }


      $deals = new MetalNickelDeals();
      $deals->import_metal_id = $this->id;
      $deals->date_uploaded = $this->date_file;
      $deals->title = $testarr[0];
      $deals->description = $testarr[1];
      $deals->total_deal_size = $testarr[2];
      $deals->contract_period = $testarr[3];
      $deals->purchase_price_a = $testarr[4];
      $deals->insurance_cost_a = $testarr[5];
      $deals->forward_price = $testarr[7];
      $deals->final_sales_price = $testarr[8];
      $deals->purchase_price_b  = $testarr[9];
      $deals->insurance_cost_b = $testarr[10];
      $deals->total_cost_price = $testarr[11];
      $deals->unrealised_profit_a = $testarr[12];
      $deals->commision =  $testarr[13];
      $deals->unrealised_profit_b = $testarr[14];
      $deals->net_unrealised = $testarr[15];
      $deals->save(false);
      unset($testarr);
    }

}
