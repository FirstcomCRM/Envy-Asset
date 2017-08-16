<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_zn".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $date_uploaded
 * @property string $date
 * @property string $zn_cash
 * @property string $zn_three_month
 * @property string $zn_stock
 */
class MetalZn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metal_zn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['import_metal_id', 'date_uploaded', 'date', 'zn_cash', 'zn_three_month', 'zn_stock'], 'required'],
            [['import_metal_id'], 'integer'],
            [['date_uploaded','date_filter'], 'safe'],
            [['date'], 'string', 'max' => 25],
            [['zn_cash', 'zn_three_month', 'zn_stock'], 'number'],
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
            'zn_cash' => 'Zn Cash',
            'zn_three_month' => 'Zn Three Month',
            'zn_stock' => 'Zn Stock',
        ];
    }
}
