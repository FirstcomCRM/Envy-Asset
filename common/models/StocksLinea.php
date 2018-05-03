<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stocks_linea".
 *
 * @property int $id
 * @property int $stocks_id Primary ID of stocks
 * @property string $sold_date Sold Date
 * @property int $sold_currency Sold Currency based at Forex Table
 * @property string $currency_rate Currency Rate
 * @property string $sold_price Sold Price
 * @property int $sold_units Sold Units
 * @property string $balance Balance = sold unit*sold_price
 */
class StocksLinea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stocks_linea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['stocks_id', 'sold_date', 'sold_currency', 'currency_rate', 'sold_price', 'sold_units', 'balance'], 'required'],
            [['stocks_id', 'sold_currency'], 'integer'],
            [['sold_date','currency_rate','sold_units','sold_price','balance'], 'safe'],

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
            'sold_date' => 'Sold Date',
            'sold_currency' => 'Sold Currency',
            'currency_rate' => 'Currency Rate',
            'sold_price' => 'Sold Price',
            'sold_units' => 'Sold Units',
            'balance' => 'Balance',
        ];
    }
}
