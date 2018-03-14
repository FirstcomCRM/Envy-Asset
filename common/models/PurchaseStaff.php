<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_staff".
 *
 * @property integer $id
 * @property string $purchase_no
 * @property string $staff
 * @property string $product
 * @property string $share
 * @property string $price
 * @property string $date
 * @property integer $salesperson
 * @property string $remarks
 * @property string $date_added
 */
class PurchaseStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff', 'product', 'price', 'date',], 'required'],
            [['price','sum_all','company_charge'], 'number'],
            [['date', 'date_added','expiry_date'], 'safe'],
            [['salesperson'], 'integer'],
            [['remarks'], 'string'],
            [['purchase_no'], 'string', 'max' => 25],
            [['trading_days', 'prorated_days', 'purchase_type','charge_type'], 'string', 'max' => 50],
            [['staff', 'product', 'share'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_no' => 'Purchase No',
            'staff' => 'Staff',
            'product' => 'Product',
            'share' => 'Security Name',
            'price' => 'Amount',
            'sum_all'=>'Commission Sum(Company)',
            'date' => 'Date',
            'salesperson' => 'Salesperson',
            'remarks' => 'Remarks',
            'date_added' => 'Date Added',
            'expiry_date'=>'Expiry Date',
            'trading_days'=>'Trading days in mth',
            'prorated_days'=>'Pro-rated days in mth',
            'purchase_type'=>'Purchase Type',
            'charge_type'=>'Charge Type',
            'company_charge'=>'Company Charge',
        ];
    }
}
