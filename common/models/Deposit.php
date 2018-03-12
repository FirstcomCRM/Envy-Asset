<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "deposit".
 *
 * @property integer $id
 * @property integer $investor
 * @property string $price
 * @property string $product
 * @property string $date
 * @property string $remarks
 */
class Deposit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deposit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['investor', 'price', 'product', 'date'], 'required'],
            [['investor'], 'integer'],
            [['price'], 'number'],
            [['date','date_added'], 'safe'],
            [['remarks'], 'string'],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'investor' => 'Investor',
            'price' => 'Amount',
            'product' => 'Product',
            'date' => 'Date',
            'remarks' => 'Remarks',
            'date_added'=>'Date Added',
        ];
    }
}
