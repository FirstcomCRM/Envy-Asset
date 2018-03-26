<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_earning".
 *
 * @property integer $id
 * @property integer $purchase_id
 * @property string $purchase_date
 * @property string $expiry_date
 * @property string $re_date
 * @property string $purchase_amount
 * @property string $customer_earn
 * @property string $company_earn
 * @property string $staff_earn
 */
class PurchaseEarning extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_earning';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
      //      [['purchase_id', 'purchase_date', 'expiry_date', 're_date', 'purchase_amount', 'customer_earn', 'company_earn', 'staff_earn'], 'required'],
            [['purchase_id','investor'], 'integer'],
            [['re_date'], 'safe'],
            [['customer_earn', 'purchase_amount','company_earn', 'staff_earn','re_metal_per','customer_earn_after','tranche'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_id' => 'Purchase ID',
            'Investor'=>'Investor',
            're_date' => 'Re Date',
            'purchase_amount'=>'Purchase Amount',
            'customer_earn' => 'Investor Return (Before)',
            'customer_earn_after'=>'Investor Return (After)',
            'company_earn' => 'Company Commission',
            'staff_earn' => 'Staff Commission',
            're_metal_per'=>'Metal %',
            'tranche'=>'Commission Tranche',
        ];
    }
}
