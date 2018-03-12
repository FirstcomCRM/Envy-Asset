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
            [['investor', 'product', 'share', 'price', 'date'], 'required'],
            [['price','sum_all'], 'number'],
            [['date'], 'safe'],
            [['remarks','purchase_no'], 'string'],
        //    [['salesperson'], 'string'],
            [['salesperson'], 'integer'],
            [['investor', 'product', 'share'], 'string', 'max' => 75],
            [['date_adedd','expiry_date'],'safe'],
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
            'share' => 'Share',
            'price' => 'Amount',
            'sum_all'=>'Commission Sum',
            'date' => 'Date',
            'salesperson'=>'Sales Person',
            'remarks' => 'Remarks',
            'expiry_date'=>'Expiry Date',
        ];
    }
}
