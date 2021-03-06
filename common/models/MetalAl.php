<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_al".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $date_uploaded
 * @property string $date
 * @property string $al_cash
 * @property string $al_three_month
 * @property string $al_stocl
 */
class MetalAl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metal_al';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['import_metal_id', 'date_uploaded', 'date', 'al_cash', 'al_three_month', 'al_stocl'], 'required'],
            [['import_metal_id'], 'integer'],
            [['date_uploaded','date_filter'], 'safe'],
            [['al_cash', 'al_three_month', 'al_stocl'], 'number'],
          //  [['al_cash', 'al_three_month', 'al_stocl'], 'string'],
            [['date'], 'string', 'max' => 25],

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
            'date_filter'=>'Date',
            'al_cash' => 'LME Aluminum Cash Settlement',
            'al_three_month' => 'LME Aluminum Three Month',
            'al_stocl' => 'LME Aluminum Stock',
        ];
    }
}
