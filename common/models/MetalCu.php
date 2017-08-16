<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_cu".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $date_uploaded
 * @property string $date
 * @property string $cu_cash
 * @property string $cu_three_month
 * @property string $cu_stock
 */
class MetalCu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metal_cu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['import_metal_id'], 'integer'],
            [['date_uploaded', 'date_filter'], 'safe'],
            [['date'], 'string', 'max' => 25],
            [['cu_cash', 'cu_three_month', 'cu_stock'], 'number'],
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
            'cu_cash' => 'LME Copper Cash-Settlement',
            'cu_three_month' => 'LME Copper 3-Month',
            'cu_stock' => 'LME Copper Stock',
        ];
    }
}
