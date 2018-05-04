<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\Purchase;

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
            [['stock', 'date', 'buy_in_price','buy_in_rate'], 'required'],
            [['date', 'date_created', 'date_edited', 'date_added','buy_in_price', 'buy_in_rate','buy_in_local','total_sold_unit','balance_unit'], 'safe'],
          //  [[], 'number','numberPattern' => '/^\s*[-+]?[0-9\,]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['added_by', 'edited_by','forex','product_id'], 'integer'],
            [['stock','ticker','exchange'], 'string', 'max' => 75],
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
            'ticker'=>'Ticker',
            'exchange'=>'Exchange',
            'buy_units'=>'Buy Units',
            'date_created' => 'Date Created',
            'date_edited' => 'Date Edited',
            'added_by' => 'Added By',
            'edited_by' => 'Edited By',
            'date_added' => 'Date Added',
            'forex'=>'Forex',
            'total_sold_unit'=>'Total Sold Units',
            'balance_unit'=>'Balance Units'
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->date = date('Y-m-d',strtotime($this->date));
            return true;
        } else {
            return false;
        }
    }
// /$model->product_id
    public function updateBU(){
      $data = Purchase::find()->where(['product'=>$this->product_id])->sum('ptotal_sold_unit');
      if (empty($data) ) {
        $data = 0;
      }
      $this->balance_unit = $this->buy_units-($this->total_sold_unit + $data);
      $this->save(false);
    }
}
