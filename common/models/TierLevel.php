<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tier_level".
 *
 * @property integer $id
 * @property string $tier_level
 * @property integer $connecting_level
 * @property string $date_added
 */
class TierLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tier_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tier_level'], 'required'],
            [['connecting_level'], 'integer'],
            [['date_added'], 'safe'],
            [['tier_level'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tier_level' => 'Tier Level',
            'connecting_level' => 'Connecting Level',
            'date_added' => 'Date Added',
        ];
    }
}
