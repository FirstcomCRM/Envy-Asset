<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_nickel_deals".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $date_uploaded
 * @property string $title
 * @property string $description
 * @property string $total_deal_size
 * @property string $contract_period
 * @property string $purchase_price_a
 * @property string $insurance_cost_a
 * @property string $forward_price
 * @property string $final_sales_price
 * @property string $purchase_price_b
 * @property string $insurance_cost_b
 * @property string $total_cost_price
 * @property string $unrealised_profit_a
 * @property string $commision
 * @property string $unrealised_profit_b
 * @property string $net_unrealised
 */
class MetalNickelDeals extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    // $test = '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/';
    public static function tableName()
    {
        return 'metal_nickel_deals';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unrealised_profit_a', 'commision', 'unrealised_profit_b', 'net_unrealised'], 'required'],
            [['import_metal_id'], 'integer'],
            [['date_uploaded','contract_period_start','contract_period_end'], 'safe'],
          //  [['purchase_price_a', 'insurance_cost_a', 'forward_price', 'final_sales_price', 'purchase_price_b', 'insurance_cost_b', 'total_cost_price', 'unrealised_profit_a', 'commision', 'unrealised_profit_b', 'net_unrealised'], 'number'],

            //use this for number validation with comma
      //      [['final_sales_price'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9\,]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['total_cost_price', 'unrealised_profit_a', 'commision', 'unrealised_profit_b', 'net_unrealised'],'number','numberPattern' => '/^\s*[-+]?[0-9\,]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],

            [['title', 'contract_period'], 'string', 'max' => 75],
            [['description'], 'string', 'max' => 100],
            [['ins_curr_a','pur_curr_a'], 'string', 'max'=>25],
            [['ins_curr_rate_a','pur_curr_rate_a','final_sales_price_per','purchase_price_a', 'insurance_cost_a', 'forward_price', 'final_sales_price'], 'number'],
            [['total_deal_size'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'import_metal_id' => 'Import Metal ID',
            'date_uploaded' => 'Date Uploaded',
            'title' => 'Title',
            'description' => 'Description',
            'total_deal_size' => 'Total Deal Size',
            'contract_period' => 'Contract Period',
            'contract_period_start'=>'Contract Period Start',
            'contract_period_end'=>'Contract Period End',
            'purchase_price_a' => 'Purchase Price',
            'insurance_cost_a' => 'Insurance Cost',
            'forward_price' => 'Forward Price',
            'final_sales_price' => 'Final Sales Price',
            'purchase_price_b' => 'Purchase Price',
            'insurance_cost_b' => 'Insurance Cost',
            'total_cost_price' => 'Total Cost Price',
            'unrealised_profit_a' => 'Realised Profit Before Commission %',
            'commision' => 'Commission',
            'unrealised_profit_b' => 'Realised Profit After Commission',
            'net_unrealised' => 'Net Realised % return',
            'pur_curr_a'=>'Purchase Currency',
            'pur_curr_rate_a'=>'Purchase Currency Rate',
            'ins_curr_a'=>'Insurance Curerncy',
            'ins_curr_rate_a'=>'Insurance Curerncy Rate',
            'final_sales_price_per'=>'Final Sales Price Percent',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
          //  $this->final_sales_price = str_replace(",", "", $this->final_sales_price);
            $this->total_cost_price = str_replace(",", "", $this->total_cost_price);
            $this->unrealised_profit_a = str_replace(",", "", $this->unrealised_profit_a);
            $this->commision = str_replace(",", "", $this->commision);
            $this->unrealised_profit_b = str_replace(",", "", $this->unrealised_profit_b);
            $this->net_unrealised = str_replace(",", "", $this->net_unrealised);
            return true;
        } else {
            return false;
        }
    }

    public function setFormat(){
      $this->total_cost_price = number_format($this->total_cost_price,2);
      $this->unrealised_profit_a = number_format($this->unrealised_profit_a,2);
      $this->commision = number_format($this->commision,2);
      $this->unrealised_profit_b = number_format($this->unrealised_profit_b,2);
      $this->net_unrealised = number_format($this->net_unrealised,2);
    }


}
