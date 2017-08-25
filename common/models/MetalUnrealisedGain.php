<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_unrealised_gain".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $description
 * @property string $usd
 * @property string $sgd
 * @property string $gain_loss
 */
class MetalUnrealisedGain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metal_unrealised_gain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['import_metal_id', 'description', 'usd', 'sgd', 'gain_loss'], 'required'],
            [['import_metal_id'], 'integer'],
            [['usd', 'sgd', 'gain_loss'], 'number'],
            [['date_uploaded'], 'safe'],
            [['description'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_uploaded'=>'Date Uploaded',
            'import_metal_id' => 'Import Metal ID',
            'description' => 'Description',
            'usd' => 'USD',
            'sgd' => 'SGD',
            'gain_loss' => 'Gain/Loss %',
        ];
    }
}
