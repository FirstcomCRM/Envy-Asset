<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $country
 * @property string $capital
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public function behaviors()
 	   {
   		return [
   			'sammaye\audittrail\LoggableBehavior'
   		];
 	   }

    public static function tableName()
    {
        return 'country';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'capital'], 'required'],
            [['country'], 'string', 'max' => 50],
            [['capital'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'capital' => 'Capital',
        ];
    }
}
