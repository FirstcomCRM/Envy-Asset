<?php

namespace common\models;

use Yii;
use common\models\InvestStock;
use common\models\InvestMetal;

/**
 * This is the model class for table "product_management".
 *
 * @property integer $id
 * @property string $product_name
 * @property string $description
 * @property string $product_code
 * @property string $product_price
 * @property string $product_cost
 * @property string $product_type
 * @property string $product_cat
 */
class ProductManagement extends \yii\db\ActiveRecord
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
        return 'product_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name', 'product_code', 'product_price', 'product_cost', 'product_type', 'product_cat'], 'required'],
            [['product_name'],'unique'],
            [['description'], 'string'],
            [['product_price', 'product_cost'], 'number'],
            [['product_name', 'product_code', 'product_type', 'product_cat'], 'string', 'max' => 100],
            [['date_adedd'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Name',
            'description' => 'Description',
            'product_code' => 'Code',
            'product_price' => 'Price',
            'product_cost' => 'Cost',
            'product_type' => 'Type',
            'product_cat' => 'Category',
        ];
    }

  /*  public function stocks(){
      $invest = new InvestStock();
      $invest->product = $this->product_name;
      $invest->date_created = date('Y-m-d');
      $this->save();
      $invest->product_id = $this->id;
      $invest->save();
    }

    public function metal(){
      $metal = new InvestMetal();
      $metal->product = $this->product_name;
      $metal->date_created = date('Y-m-d');
      $this->save();
      $metal->product_id = $this->id;
      $metal->save();
    }*/
}
