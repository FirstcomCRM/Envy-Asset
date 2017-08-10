<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "deposit_line".
 *
 * @property integer $id
 * @property integer $header_id
 * @property string $deposit
 * @property string $date_added
 */
class DepositLine extends \yii\db\ActiveRecord
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
        return 'deposit_line';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['header_id', 'deposit', 'date_added'], 'required'],
            [['deposit'],'required'],
            [['header_id'], 'integer'],
            [['deposit'], 'number'],
            [['date_added','action'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'header_id' => 'Header ID',
            'action'=>'Action',
            'deposit' => 'Deposit',
            'date_added' => 'Date Added',
        ];
    }
}
