<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stocks".
 *
 * @property integer $id
 * @property string $stock
 * @property string $price
 * @property string $add_in
 * @property string $buy_in_price
 * @property string $current_market
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
            [['stock', 'price', 'add_in', 'buy_in_price', 'current_market', 'unrealized'], 'required'],
            [['price'], 'number'],
            [['date_created', 'date_edited', 'date_added'], 'safe'],
            [['added_by', 'edited_by'], 'integer'],
            [['stock'], 'string', 'max' => 75],
            [['add_in', 'buy_in_price', 'current_market', 'unrealized'], 'string', 'max' => 100],
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
            'price' => 'Price',
            'add_in' => 'Add In',
            'buy_in_price' => 'Buy In Price',
            'current_market' => 'Current Market',
            'unrealized' => 'Unrealized',
            'date_created' => 'Date Created',
            'date_edited' => 'Date Edited',
            'added_by' => 'Added By',
            'edited_by' => 'Edited By',
            'date_added' => 'Date Added',
        ];
    }
}
