<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_ni".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $date_uploaded
 * @property string $date
 * @property string $ni_cash
 * @property string $ni_three_month
 * @property string $ni_stock
 */
class MetalNi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metal_ni';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['import_metal_id'], 'integer'],
            [['date_uploaded', 'date_filter'], 'safe'],
            [['ni_cash', 'ni_three_month', 'ni_stock'], 'required'],
            [['date'], 'string', 'max' => 25],
            [['ni_cash', 'ni_three_month', 'ni_stock'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'import_metal_id' => 'Import Metal ID',
            'date_uploaded' => 'Date Uploaded',
            'date' => 'Date',
            'date_filter'=>'Date Filter',
            'ni_cash' => 'LME Nickel Cash-Settlement',
            'ni_three_month' => 'LME Nickel 3-month',
            'ni_stock' => 'LME Nickel Stock',
        ];
    }
}
