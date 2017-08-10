<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_permission".
 *
 * @property integer $id
 * @property string $controller
 * @property string $action
 * @property integer $user_group_id
 */
class UserPermission extends \yii\db\ActiveRecord
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
        return 'user_permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller', 'action', 'user_group_id'], 'required'],
            [['user_group_id'], 'integer'],
            [['controller', 'action'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'user_group_id' => 'User Group ID',
        ];
    }
}
