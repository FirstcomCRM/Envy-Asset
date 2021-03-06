<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "commission".
 *
 * @property integer $id
 * @property integer $transact_id
 * @property string $transact_type
 * @property string $transact_amount
 * @property string $transact_date
 * @property integer $sales_person
 * @property string $commision_percent
 * @property string $commission
 * @property string $date_added
 */
class Commission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transact_type', 'transact_amount', 'transact_date', 'sales_person', 'commision_percent', 'commission'], 'required'],
            [['transact_id', 'sales_person'], 'integer'],
            [['transact_amount', 'commision_percent', 'commission','commission_comp'], 'number'],
            [['transact_date', 'date_added','date_expire','re_month'], 'safe'],
            [['transact_no'], 'string'],
            [['transact_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
          //  'transact_id' => 'Transaction ID',
            'transact_id' => 'Purchase ID',
            'transact_no'=> 'Purchase No',
            'transact_type' => 'Transaction Type',
            //'transact_amount' => 'Transaction Amount',
            'transact_amount' => 'Amount',
            //'transact_date' => 'Transaction Date',
            'transact_date' => 'Purchase Date',
            'sales_person' => 'Sales Person',
            'commision_percent' => 'Commision Percentage',
            'commission' => 'Staff Commission',
            'date_added' => 'Date Added',
            'commission_comp'=>'Company Commission',
            'date_expire'=>'Expiry Date',
        ];
    }
}
