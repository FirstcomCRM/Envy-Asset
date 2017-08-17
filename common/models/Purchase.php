<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase".
 *
 * @property integer $id
 * @property string $investor
 * @property string $product
 * @property string $share
 * @property string $price
 * @property string $date
 * @property string $remarks
 */
class Purchase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['investor', 'product', 'share', 'price', 'date', 'remarks'], 'required'],
            [['price'], 'number'],
            [['date'], 'safe'],
            [['remarks'], 'string'],
            [['investor', 'product', 'share'], 'string', 'max' => 75],
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
            'product' => 'Product',
            'share' => 'Share',
            'price' => 'Price',
            'date' => 'Date',
            'remarks' => 'Remarks',
        ];
    }
}
