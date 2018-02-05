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
            [['staff', 'product', 'share', 'price', 'date', 'salesperson'], 'required'],
            [['price'], 'number'],
            [['date', 'date_added'], 'safe'],
            [['salesperson'], 'integer'],
            [['remarks'], 'string'],
            [['purchase_no'], 'string', 'max' => 25],
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
            'share' => 'Share',
            'price' => 'Price',
            'date' => 'Date',
            'salesperson' => 'Salesperson',
            'remarks' => 'Remarks',
            'date_added' => 'Date Added',
        ];
    }
}
