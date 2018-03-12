<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "withdraw_staff".
 *
 * @property integer $id
 * @property integer $staff
 * @property string $price
 * @property string $category
 * @property string $date
 * @property string $remarks
 * @property string $date_added
 */
class WithdrawStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'withdraw_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff', 'price', 'product', 'date'], 'required'],
            [['staff'], 'integer'],
            [['price'], 'number'],
            [['date', 'date_added'], 'safe'],
            [['remarks'], 'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff' => 'Staff',
            'price' => 'Amount',
            'product' => 'Product',
            'date' => 'Date',
            'remarks' => 'Remarks',
            'date_added' => 'Date Added',
        ];
    }
}
