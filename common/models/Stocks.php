<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

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

    public function behaviors(){
       return [
           [
               'class' => BlameableBehavior::className(),
               'createdByAttribute' => 'added_by',
               'updatedByAttribute' => 'edited_by',
           ],
           [
             'class' => TimestampBehavior::className(),
             'createdAtAttribute' => 'date_added',
             'updatedAtAttribute' => 'date_edited',
           //  'value' => new Expression('NOW()'),
               'value' => date('Y-m-d H:i:s'),
           ],
       ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock', 'date', 'buy_in_price'], 'required'],
            [['date', 'date_created', 'date_edited', 'date_added','sold_date','buy_in_price', 'buy_in_rate','buy_in_local'], 'safe'],
          //  [[], 'number','numberPattern' => '/^\s*[-+]?[0-9\,]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['added_by', 'edited_by','forex','product_id','sold_units'], 'integer'],
            [['stock'], 'string', 'max' => 75],
            [['buy_units'], 'string', 'max' => 50],

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
            'buy_in_price' => 'Buy In Price',
            'buy_in_rate'=>'Buy in Price Rate',
            'buy_in_local'=>'Local(SGD)',
            'sold_date'=>'Sold Date',
            'sold_units'=>'Sold Units',
            'buy_units'=>'Buy Units',
            'date_created' => 'Date Created',
            'date_edited' => 'Date Edited',
            'added_by' => 'Added By',
            'edited_by' => 'Edited By',
            'date_added' => 'Date Added',
            'forex'=>'Forex',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
          //  $this->final_sales_price = str_replace(",", "", $this->final_sales_price);
            $this->date = date('Y-m-d',strtotime($this->date));
            $this->sold_date = date('Y-m-d',strtotime($this->sold_date));


            /*
            $model->date = date('Y-m-d', strtotime($model->date) );
          //    print_r($model->sold_date);die();
            $model->sold_date = date('Y-m-d', strtotime($model->sold_date) );
            */

            return true;
        } else {
            return false;
        }
    }
}
