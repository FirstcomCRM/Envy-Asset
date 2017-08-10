<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_group".
 *
 * @property integer $id
 * @property string $usergroup
 * @property string $description
 */
class UserGroup extends \yii\db\ActiveRecord
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
        return 'user_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usergroup'], 'required'],
            [['usergroup'],'unique'],
            [['description'], 'string'],
            [['usergroup'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usergroup' => 'User Group',
            'description' => 'Description',
        ];
    }
}
