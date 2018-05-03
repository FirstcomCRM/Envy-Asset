<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_line".
 *
 * @property int $id
 * @property int $purchase_id Purchase ID
 * @property string $psold_date Purchase Sold Date
 * @property string $psold_currency Purchase Sold Currency
 * @property string $pcurrency_rate Purchase Currency Rate
 * @property string $psold_price Purchase Sold Price
 * @property string $psold_units Purchase Sold Units
 * @property string $pbalance Purchase Balance
 */
class PurchaseLine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_line';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['id', 'purchase_id'], 'integer'],
            [['psold_date','pcurrency_rate', 'psold_price', 'psold_units', 'pbalance'], 'safe'],
            [['psold_currency'], 'number'],

          //  [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_id' => 'Purchase ID',
            'psold_date' => 'Sold Date',
            'psold_currency' => 'Sold Currency',
            'pcurrency_rate' => 'Currency Rate',
            'psold_price' => 'Sold Price',
            'psold_units' => 'Sold Units',
            'pbalance' => 'Balance',
        ];
    }
}
