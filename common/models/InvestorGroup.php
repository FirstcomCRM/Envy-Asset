<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_group".
 *
 * @property integer $id
 * @property string $customer_group
 * @property string $description
 */
class InvestorGroup extends \yii\db\ActiveRecord
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
        return 'investor_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_group', 'description'], 'required'],
            [['description'], 'string'],
            [['customer_group'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_group' => 'Group',
            'description' => 'Description',
        ];
    }
}
