<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\MetalUnrealisedGain;
use common\models\PurchaseEarning;
use common\models\MetalNickelDeals;


/**
 * This is the model class for table "purchase".
 *
 * @property integer $id
 * @property string $investor
 * @property string $product
 * @property string $share
 * @property string $price
 * @property string $date
 * @property string $remarks
 */
class Purchase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase';
    }
    public function behaviors()
    {
     /*return [
       'sammaye\audittrail\LoggableBehavior'
     ];*/
     return [
         [
             'class' => BlameableBehavior::className(),
             'createdByAttribute' => 'added_by',
             'updatedByAttribute' => 'edited_by',
         ],
         [
           'class' => TimestampBehavior::className(),
           'createdAtAttribute' => 'date_added',
           'updatedAtAttribute' => 'date_edited',
         //  'value' => new Expression('NOW()'),
             'value' => date('Y-m-d H:i:s'),
         ],
     ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['investor', 'product', 'price', 'date','company_charge'], 'required'],
            [['sum_all','company_charge'], 'number'],
            [['date'], 'safe'],
            [['trading_days','prorated_days','buy_currency','added_by','edited_by'],'integer'],
            [['remarks','purchase_no'], 'string'],
        //    [['salesperson'], 'string'],
      //      [['salesperson'], 'integer'],
            [['investor', 'product', 'share'], 'string', 'max' => 75],
            [['purchase_type','charge_type'], 'string', 'max' => 50],
            [['type'],'string','max'=>25],
            [['metal_expiry_date','true_expiry_date','salesperson','nickel_date','nickel_expiry','price','customer_earn','company_earn','staff_earn','buy_curr_rate','buy_units','ptotal_sold_unit','date_created','date_added','date_edited','buy_in_price'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        //    'id' => 'ID',
            'id' => 'ID',
            'purchase_no'=>'Purchase No',
            'type'=>'Type',
            'investor' => 'Investor',
            'product' => 'Product',
            'share' => 'Security Name',
            'price' => 'Amount',
            'sum_all'=>'Commission Sum(Company)',
            'date' => 'Date',
            'salesperson'=>'Sales Person',
            'remarks' => 'Remarks',
            'true_expiry_date'=>'Expiry Date',
            'nickel_date'=>'Nickel Date',
            'nickel_expiry'=>'Nickel Expiry Date',
            'expiry_date'=>'Metal Expiry Date',
            'trading_days'=>'Trading days in Month',
            'prorated_days'=>'Pro-rated days in Month',
            'purchase_type'=>'Purchase Type',
            'charge_type'=>'Charge Type',
            'company_charge'=>'Company Charge %',
            'customer_earn'=>'Investor Return',
            'company_earn'=>'Company Commission',
            'staff_earn'=>'Staff Commission',
            'ptotal_sold_unit'=>'Total Sold Units',
            'buy_currency'=>'Buy Currency',
            'buy_curr_rate'=>'Buy Currency Rate',
            'buy_units'=>'Buy Units',
            'buy_in_price'=>'Buy In Price',
        ];
    }

    public function setDefaults(){
      $this->date = date('d M Y');
      $this->purchase_type = 'Metal';
      $this->company_charge = 0.00;
      $this->trading_days = 20;
      $this->prorated_days = 15;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
          //  $this->final_sales_price = str_replace(",", "", $this->final_sales_price);
            $this->ptotal_sold_unit = str_replace(",","",$this->ptotal_sold_unit);
            $this->date = date('Y-m-d', strtotime($this->date) );
            $this->metal_expiry_date = date('Y-m-d', strtotime($this->metal_expiry_date) );
            $this->date_added = date('Y-m-d h:i:s');
        //    $x = $this->company_charge/100;
        //    $this->company_charge = $x;
            $this->nickel_date = date('Y-m-d', strtotime($this->nickel_date) );
            $this->nickel_expiry= date('Y-m-d', strtotime($this->nickel_expiry) );
            if ($this->purchase_type == 'Metal') {
              $this->true_expiry_date = $this->metal_expiry_date;
            }elseif ($this->purchase_type == 'Nickel') {
              $this->true_expiry_date = $this->nickel_expiry;
            }else{
              $this->true_expiry_date = null;
            }
            //print_r($this->company_charge);
            //die('@@');
            return true;
        } else {
            return false;
        }
    }

    public function tierFunc($multiplier){
      $m = 0;
      if ($multiplier<=0.30) {
        $m = 0.15;
      }elseif($multiplier>0.30 && $multiplier<=0.40){
        $m = 0.18;
      }elseif ($multiplier>0.40 && $multiplier <=0.50) {
        $m = 0.20;
      }else {
        $m = 0.25;
      }
      return $m;
    }

    public function earning($date_test){
      $namount= 0;
      $customer_amount = 0;
      $staff_earn = 0;

      if ($this->purchase_type == 'Metal') {

        $comm = MetalUnrealisedGain::find()->where(['true_date'=>$date_test])->one();
        if (empty($comm) ) {
          $multiplier = 0;
          $date_re = $date_test;
        }else{
          $multiplier = $comm->re_gain_loss;
          $date_re = $comm->true_date;
        }

      }else{

        $d = new \DateTime($date_test);
        $end_date = $d->format('Y-m-t');
        $comm = MetalNickelDeals::find()->where(['contract_period_end'=>$end_date])->one();
        if (empty($comm) ) {
          $multiplier = 0;
          $date_re = $date_test;
        }else{
          $multiplier = $comm->unrealised_profit_a;
          $date_re = $date_test;
        }

      }

      $earning = new PurchaseEarning();
      $earning->purchase_id = $this->id;
      $earning->purchase_date = $this->date;
      $earning->expiry_date = $this->expiry_date;
      $earning->purchase_amount = $this->price;
      $earning->re_date = $date_re;
      $earning->re_metal_per = $multiplier;

      if ($multiplier<=0.30) {
        $earning->tranche = 0.15;
      }elseif($multiplier>0.30 && $multiplier<=0.40){
        $earning->tranche = 0.18;
      }elseif ($multiplier>0.40 && $multiplier <=0.50) {
        $earning->tranche = 0.20;
      }else {
        $earning->tranche = 0.25;
      }

      $compare_start =  date('Y-m-01',strtotime($this->date) );
      $compare_end  = date('Y-m-01',strtotime($this->metal_expiry_date) );

      if ($this->charge_type == 'Others') {

         if ($date_test == $compare_start || $date_test == $compare_end) {
            $before_return = $earning->purchase_amount*$multiplier;
            $traded = $before_return/$this->trading_days;
            $true_return = $traded*$this->prorated_days;
            $earning->customer_earn = $true_return;
            $earning->company_earn = $earning->customer_earn*$this->company_charge;
            $earning->customer_earn_after = $earning->customer_earn - $earning->company_earn;
            $earning->staff_earn = $earning->company_earn/2;
         }else{
           //common formula
           $earning->customer_earn = $earning->purchase_amount*$multiplier;
           $earning->company_earn = $earning->customer_earn*$this->company_charge;
           $earning->customer_earn_after = $earning->customer_earn - $earning->company_earn;
           $earning->staff_earn = $earning->company_earn/2;
         }

      }else{
        //insert here logic if charge type is tier
        $earning->customer_earn = 0;
        $earning->customer_earn_after = 0;
        $earning->company_earn  = 0;
        $earning->staff_earn  = 0;

      }
        $earning->save(false);

      //end of function
    }

}
