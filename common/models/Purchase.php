<?php

namespace common\models;

use Yii;

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
            [['investor', 'product', 'price', 'date'], 'required'],
            [['price','sum_all','company_charge','customer_earn','company_earn','staff_earn'], 'number'],
            [['date'], 'safe'],
            [['remarks','purchase_no'], 'string'],
        //    [['salesperson'], 'string'],
      //      [['salesperson'], 'integer'],
            [['investor', 'product', 'share'], 'string', 'max' => 75],
            [['trading_days', 'prorated_days', 'purchase_type','charge_type'], 'string', 'max' => 50],
            [['date_adedd','expiry_date','salesperson'],'safe'],
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
            'expiry_date'=>'Expiry Date',
            'trading_days'=>'Trading days in mth',
            'prorated_days'=>'Pro-rated days in mth',
            'purchase_type'=>'Purchase Type',
            'charge_type'=>'Charge Type',
            'company_charge'=>'Company Charge %',
            'customer_earn'=>'Customer Earn',
            'company_earn'=>'Company Earn',
            'staff_earn'=>'Staff Earn',
        ];
    }
}
