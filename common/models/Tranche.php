<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tranche".
 *
 * @property integer $id
 * @property string $min_val
 * @property string $max_val
 * @property string $value
 */
class Tranche extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tranche';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_val', 'max_val', 'value'], 'required'],
            [['min_val', 'max_val', 'value'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_val' => 'Minimum Value',
            'max_val' => 'Maximum Value',
            'value' => 'Value',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
          //  $this->final_sales_price = str_replace(",", "", $this->final_sales_price);
            $this->min_val = $this->min_val/100;
            $this->max_val = $this->max_val/100;
            $this->value = $this->value/100;
            return true;
        } else {
            return false;
        }
    }
}
