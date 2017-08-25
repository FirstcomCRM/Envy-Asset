<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_unrealised".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $date_uploaded
 * @property string $commodity
 * @property string $position
 * @property string $entry_date_usd
 * @property string $entry_price_usd
 * @property string $entry_value_usd
 * @property string $exit_date_usd
 * @property string $exit_price_usd
 * @property string $exit_value_usd
 * @property string $realised_gain_usd
 * @property string $realised_gain_percent
 * @property string $profit_lost_usd
 * @property string $profit_lost_sgd
 */
class MetalUnrealised extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metal_unrealised';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['import_metal_id'], 'integer'],
            [['date_uploaded', 'entry_date_usd', 'exit_date_usd'], 'safe'],
            [['entry_price_usd', 'entry_value_usd', 'exit_price_usd', 'exit_value_usd', 'realised_gain_usd', 'profit_lost_usd', 'profit_lost_sgd','realised_gain_percent'], 'number'],
            [['commodity'], 'string', 'max' => 75],
            [['position'], 'string', 'max' => 50],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'import_metal_id' => 'Import Metal ID',
            'date_uploaded' => 'Date Uploaded',
            'commodity' => 'Commodity',
            'position' => 'Position',
            'entry_date_usd' => 'Entry Date USD',
            'entry_price_usd' => 'Entry Price USD',
            'entry_value_usd' => 'Entry Value USD',
            'exit_date_usd' => 'Exit Date USD',
            'exit_price_usd' => 'Exit Price USD',
            'exit_value_usd' => 'Exit Value USd',
            'realised_gain_usd' => 'Realised Gain/Loss Usd',
            'realised_gain_percent' => 'Realised Gain/Loss %',
            'profit_lost_usd' => 'Profit/Lost after transaction fee Usd',
            'profit_lost_sgd' => 'Profit/Lost after transaction fee SGD',
        ];
    }
}
