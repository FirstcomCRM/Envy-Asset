<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stocks_line".
 *
 * @property integer $id
 * @property integer $stocks_id
 * @property string $month
 * @property integer $month_curr
 * @property string $month_price
 * @property string $month_rate
 * @property string $unrealized_curr
 * @property string $unrealized_local
 */
class StocksLine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stocks_line';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['month', 'month_price', 'month_rate'], 'required'],
            [['stocks_id', 'month_curr'], 'integer'],
            [['month','month_price','month_rate','unrealized_curr','unrealized_local'], 'safe'],
          //  [[], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stocks_id' => 'Stocks ID',
            'month' => 'Month',
            'month_curr' => 'Month Currency',
            'month_price' => 'Month End Price',
            'month_rate' => 'Month End Price Rate',
            'unrealized_curr' => 'Unrealized Gain/Loss',
            'unrealized_local' => 'Unrealized Gain/Loss (%)',
        ];
    }
}
