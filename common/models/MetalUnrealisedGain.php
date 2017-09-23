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
            [['usd', 'sgd', 'gain_loss','re_usd','re_sgd','re_gain_loss'], 'number'],
            [['date_uploaded'], 'safe'],
            [['description','re_description'], 'string', 'max' => 75],
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
            'description' => 'Unrealised Description',
            'usd' => 'USD',
            'sgd' => 'SGD',
            'gain_loss' => 'Gain/Loss %',
            're_description'=>'Realised Description',
            're_usd'=>'USD',
            're_sgd'=>'SGD',
            're_gain_loss'=>'Gain/Loss %',
        ];
    }
}
