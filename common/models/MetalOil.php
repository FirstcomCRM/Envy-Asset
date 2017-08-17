<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_oil".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $date_uploaded
 * @property integer $date
 * @property string $oil_price
 * @property string $oil_open
 * @property string $oil_high
 * @property string $oil_low
 * @property string $oil_change
 */
class MetalOil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metal_oil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['import_metal_id'], 'integer'],
            [['date_uploaded', 'date_filter'], 'safe'],
            [['oil_volume','date'], 'string', 'max' => 25],
            [['oil_price', 'oil_open', 'oil_high', 'oil_low', 'oil_change',],'number'],
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
            'date' => 'Date',
            'date_filter'=>'Date',
            'oil_price' => 'Price',
            'oil_open' => 'Open',
            'oil_high' => 'High',
            'oil_low' => 'Low',
            'oil_change' => 'Change%',
            'oil_volume'=> 'Volume',
        ];
    }
}
