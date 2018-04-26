<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "forex".
 *
 * @property integer $id
 * @property string $currency_code
 * @property string $currency_desc
 */
class Forex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_code', 'currency_desc'], 'required'],
            [['currency_desc'], 'string'],
            [['currency_code'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency_code' => 'Currency Code',
            'currency_desc' => 'Description',
        ];
    }
}
