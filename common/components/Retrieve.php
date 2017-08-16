<?php
namespace common\components;
use common\models\User;
use common\models\InvestStock;
use common\models\InvestMetal;
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
  public static function retrieveProduct($id){
    $prod = InvestStock::find()->where(['id'=>$id])->one();
    if (!empty($prod)) {
      return $prod->product;
    }else{
      return $prod = null;
    }
  }

  public static function retrieveMetalProduct($id){
    $prod = InvestMetal::find()->where(['id'=>$id])->one();
    if (!empty($prod)) {
      return $prod->product;
    }else{
      return $prod = null;
    }
  }

  public static function get_numberFormat($number){
    return number_format($number,2,',','.');
  }

}
?>
