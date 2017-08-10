<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_audit_trail".
 *
 * @property integer $id
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $model
 * @property string $field
 * @property string $stamp
 * @property string $user_id
 * @property string $model_id
 */
class TblAuditTrail extends \yii\db\ActiveRecord
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
        return 'tbl_audit_trail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_value', 'new_value'], 'string'],
            [['action', 'model', 'stamp', 'model_id'], 'required'],
            [['stamp'], 'safe'],
            [['action', 'model', 'field', 'user_id', 'model_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'action' => 'Action',
            'model' => 'Model',
            'field' => 'Field',
            'stamp' => 'Stamp',
            'user_id' => 'User ID',
            'model_id' => 'Model ID',
        ];
    }
}
