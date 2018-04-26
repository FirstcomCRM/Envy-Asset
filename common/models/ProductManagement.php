<?php

namespace common\models;

use Yii;
use common\models\InvestStock;
use common\models\InvestMetal;
use yii\db\Command;
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
            [['invest_type'],'integer'],
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
            'product_type' => 'Product Type',
            'product_cat' => 'Category',
            'invest_type'=>'Type',
        ];
    }


    public function addProduct($name,$ids){
      $connection = Yii::$app->db;
      $connection->createCommand()->insert('product_management',[
        'product_name'=>$name,
        'description'=>'0',
        'product_code'=>'0',
        'product_price'=>0,
        'product_cost'=>0,
        'product_type'=>1,
        'invest_type'=>$ids,
        'product_cat'=>1,
      ])->execute();

      $lastInsertID = $connection->getLastInsertID();
      return $lastInsertID;

    }

    public function getCat(){
          return $this->hasOne(ProductCategory::className(),['id' => 'product_cat'] );
    }

    public function getType(){
          return $this->hasOne(ProductType::className(),['id' => 'product_type'] );
    }


}
