<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stocks".
 *
 * @property integer $id
 * @property string $stock
 * @property string $date
 * @property string $price
 * @property string $add_in
 * @property string $buy_in_price
 * @property string $sold_price
 * @property string $month_end_price
 * @property string $unrealized
 * @property string $date_created
 * @property string $date_edited
 * @property integer $added_by
 * @property integer $edited_by
 * @property string $date_added
 */
class Stocks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stocks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock', 'date', 'price', 'add_in', 'buy_in_price', 'sold_price', 'month_end_price', 'unrealized'], 'required'],
            [['date', 'date_created', 'date_edited', 'date_added','sold_date'], 'safe'],
            [['price', 'buy_in_price', 'sold_price', 'month_end_price', 'unrealized','add_in_rate','buy_in_rate','sold_price_rate','month_end_rate','unrealized_rate',], 'number'],
            [['added_by', 'edited_by'], 'integer'],
            [['stock'], 'string', 'max' => 75],
            [['sold_units','buy_units'], 'string', 'max' => 50],
            [['add_in'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stock' => 'Stock',
            'date' => 'Date',
            'price' => 'Price',
            'add_in' => 'Add In',
            'buy_in_price' => 'Buy In Price',
            'sold_price' => 'Sold Price',
            'month_end_price' => 'Month End Price',
            'unrealized' => 'Unrealized',

            'add_in_rate'=>'Add in Rate',
            'buy_in_rate'=>'Buy in Price Rate',
            'sold_price_rate'=>'Sold Price Rate',
            'month_end_rate'=>'Month End Price Rate',
            'unrealized_rate'=>'Unrealized Rate',
            'sold_date'=>'Sold Date',
            'sold_units'=>'Sold Units',
            'buy_units'=>'Buy Units',

            'date_created' => 'Date Created',
            'date_edited' => 'Date Edited',
            'added_by' => 'Added By',
            'edited_by' => 'Edited By',
            'date_added' => 'Date Added',
        ];
    }
}
