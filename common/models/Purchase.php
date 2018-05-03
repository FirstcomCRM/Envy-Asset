<?php

namespace common\models;

use Yii;
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['investor', 'product', 'price', 'date','trading_days','prorated_days','company_charge'], 'required'],
            [['sum_all','company_charge'], 'number'],
            [['date'], 'safe'],
            [['trading_days','prorated_days','sold_currency'],'integer'],
            [['remarks','purchase_no'], 'string'],
        //    [['salesperson'], 'string'],
      //      [['salesperson'], 'integer'],
            [['investor', 'product', 'share'], 'string', 'max' => 75],
            [['purchase_type','charge_type'], 'string', 'max' => 50],
            [['date_adedd','expiry_date','salesperson','nickel_date','nickel_expiry','price','customer_earn','company_earn','staff_earn','sold_price','sold_price_rate','ptotal_sold_unit'],'safe'],
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
            'investor' => 'Investor',
            'product' => 'Product',
            'share' => 'Security Name',
            'price' => 'Amount',
            'sum_all'=>'Commission Sum(Company)',
            'date' => 'Date',
            'salesperson'=>'Sales Person',
            'remarks' => 'Remarks',
            'nickel_date'=>'Nickel Date',
            'nickel_expiry'=>'Nickel Expiry Date',
            'expiry_date'=>'Expiry Date',
            'trading_days'=>'Trading days in Month',
            'prorated_days'=>'Pro-rated days in Month',
            'purchase_type'=>'Purchase Type',
            'charge_type'=>'Charge Type',
            'company_charge'=>'Company Charge %',
            'customer_earn'=>'Investor Return',
            'company_earn'=>'Company Commission',
            'staff_earn'=>'Staff Commission',
            'ptotal_sold_unit'=>'Total Sold Units',
        ];
    }

    public function earnMetal(){

    }

    public function earnNickel(){

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
      $compare_end  = date('Y-m-01',strtotime($this->expiry_date) );

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
