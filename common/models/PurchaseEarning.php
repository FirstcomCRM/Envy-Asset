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
            [['purchase_id'], 'integer'],
            [['purchase_date', 'expiry_date', 're_date'], 'safe'],
            [['purchase_amount', 'customer_earn', 'company_earn', 'staff_earn','re_metal_per'], 'number'],
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
            'purchase_date' => 'Purchase Date',
            'expiry_date' => 'Expiry Date',
            're_date' => 'Re Date',
            'purchase_amount' => 'Purchase Amount',
            'customer_earn' => 'Customer Earn',
            'company_earn' => 'Company Earn',
            'staff_earn' => 'Staff Earn',
            're_metal_per'=>'Metal %',
        ];
    }
}
