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
            [['import_metal_id', 'date_uploaded', 'unrealised_profit_a', 'commision', 'unrealised_profit_b', 'net_unrealised'], 'required'],
            [['import_metal_id'], 'integer'],
            [['date_uploaded'], 'safe'],
            [['purchase_price_a', 'insurance_cost_a', 'forward_price', 'final_sales_price', 'purchase_price_b', 'insurance_cost_b', 'total_cost_price', 'unrealised_profit_a', 'commision', 'unrealised_profit_b', 'net_unrealised'], 'number'],
            [['title', 'contract_period'], 'string', 'max' => 75],
            [['description'], 'string', 'max' => 100],
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
            'purchase_price_a' => 'Purchase Price A',
            'insurance_cost_a' => 'Insurance Cost A',
            'forward_price' => 'Forward Price',
            'final_sales_price' => 'Final Sales Price',
            'purchase_price_b' => 'Purchase Price B',
            'insurance_cost_b' => 'Insurance Cost B',
            'total_cost_price' => 'Total Cost Price',
            'unrealised_profit_a' => 'Unrealised Profit A',
            'commision' => 'Commission',
            'unrealised_profit_b' => 'Unrealised Profit B',
            'net_unrealised' => 'Net Unrealised',
        ];
    }
}
