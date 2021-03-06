<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metal_au".
 *
 * @property integer $id
 * @property integer $import_metal_id
 * @property string $date_uploaded
 * @property string $date
 * @property string $au_fixing
 */
class MetalAu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metal_au';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['import_metal_id'], 'integer'],
            [['date_uploaded','date_filter'], 'safe'],
            [['date'], 'string', 'max' => 25],
            [['au_fixing'],'number'],
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
            'au_fixing' => 'Gold London Fixing',
        ];
    }
}
