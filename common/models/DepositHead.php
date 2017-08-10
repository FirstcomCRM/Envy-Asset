<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "deposit_head".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $customer
 * @property string $data_created
 */
class DepositHead extends \yii\db\ActiveRecord
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
        return 'deposit_head';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['customer_id', 'customer', 'data_created'], 'required'],
            [['customer_id'], 'integer'],
            [['date_created'], 'safe'],
            [['customer'], 'string', 'max' => 100],
            [['customer'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'customer' => 'Customer',
            'date_created' => 'Date Created',
        ];
    }
}
