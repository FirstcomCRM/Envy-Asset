<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "deposit".
 *
 * @property integer $id
 * @property integer $investor
 * @property string $price
 * @property string $category
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
            [['investor', 'price', 'category', 'date', 'remarks'], 'required'],
            [['investor'], 'integer'],
            [['price'], 'number'],
            [['date'], 'safe'],
            [['remarks'], 'string'],
            [['category'], 'string', 'max' => 75],
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
            'price' => 'Price',
            'category' => 'Product Category',
            'date' => 'Date',
            'remarks' => 'Remarks',
        ];
    }
}
