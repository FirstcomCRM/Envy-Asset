<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "withdraw_line".
 *
 * @property integer $id
 * @property integer $header_id
 * @property string $withdraw
 * @property string $date_added
 */
class WithdrawLine extends \yii\db\ActiveRecord
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
        return 'withdraw_line';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['header_id', 'withdraw', 'date_added'], 'required'],
            [['withdraw'], 'required'],
            [['header_id'], 'integer'],
            [['withdraw'], 'number'],
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
            'withdraw' => 'Withdraw',
            'date_added' => 'Date Added',
        ];
    }
}
