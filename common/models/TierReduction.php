<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tier_reduction".
 *
 * @property integer $id
 * @property string $highest_percent
 * @property string $reduction_percent
 * @property string $lowesst_percent
 * @property string $date_added
 */
class TierReduction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tier_reduction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['highest_percent', 'reduction_percent', 'lowest_percent'], 'required'],
            [['highest_percent', 'reduction_percent', 'lowest_percent'], 'number'],
            [['date_added'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'highest_percent' => 'Highest Percent',
            'reduction_percent' => 'Reduction Percent',
            'lowest_percent' => 'Lowest Percent',
            'date_added' => 'Date Added',
        ];
    }
}
