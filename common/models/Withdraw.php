<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "withdraw".
 *
 * @property integer $id
 * @property integer $investor
 * @property string $price
 * @property string $category
 * @property string $date
 * @property string $remarks
 */
class Withdraw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'withdraw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['investor', 'price', 'product', 'date'], 'required'],
            [['investor','product_type'], 'integer'],
            [['price'], 'number'],
            [['date'], 'safe'],
            [['remarks','description'], 'string'],
            [['date_adedd'],'safe'],
          //  [['category'], 'string', 'max' => 75],
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
            'product_type'=>'Product Type',
            'description'=>'Description',
        ];
    }
}
