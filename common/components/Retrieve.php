<?php
namespace common\components;
use common\models\User;
use common\models\InvestStock;
use common\models\InvestMetal;
use common\models\Investor;
use common\models\ProductManagement;
use common\models\ProductCategory;
/*
Title: retrieve.php
Date: 2017-08-02
Description: Use to retrieve information from various models, such as username etc
Developer: EDR
*/

Class Retrieve{
  //EDR, retrieve the user profile, particulart the username.
  public static function retrieveUsername($id){
    $users = User::find()->where(['id'=>$id])->one();
    if (!empty($users)) {
      return $users->username;
    }else {
      return $users = null;
    }

  }

  //EDR retrive the product name used in Investment area
/*  public static function retrieveProduct($id){
    $prod = InvestStock::find()->where(['id'=>$id])->one();
    if (!empty($prod)) {
      return $prod->product;
    }else{
      return $prod = null;
    }
  }*/

  /*public static function retrieveMetalProduct($id){
    $prod = InvestMetal::find()->where(['id'=>$id])->one();
    if (!empty($prod)) {
      return $prod->product;
    }else{
      return $prod = null;
    }
  }*/

  //EDR use the french notation format instead of the ISO numeric format
  public static function get_numberFormat($number){
    return number_format($number,2,',','.');
  }

  public static function retrieveFormat($number){
    return number_format($number,2);
  }

  public static function retrieveInvestor($id){
    $invest = Investor::find()->where(['id'=>$id])->one();
    if (!empty($invest)) {
      return $invest->company_name;
    }else {
      return $invest = null;
    }
  }

  public static function retrieveProductName($id){
    $prod = ProductManagement::find()->where(['id'=>$id])->one();
    if (!empty($prod)) {
      return $prod->product_name;
    }else{
      return $prod = null;
    }
  }

  public static function retrieveProductCat($id){
    $cat = ProductCategory::find()->where(['id'=>$id])->one();
    if (!empty($cat)) {
       return $cat->category;
    }else {
      return $prod = null;
    }
  }

}
?>
