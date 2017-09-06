<?php
namespace common\components;
use common\models\User;
use common\models\UserManagement;
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
  //EDR, retrieve the user profile, particularly the username.
  public static function retrieveUsername($id){
    $users = User::find()->where(['id'=>$id])->one();
    if (!empty($users)) {
      return $users->username;
    }else {
      return $users = null;
    }

  }

    //EDR retrieve data from UserManagement, also the user profile
  public static function retrieveUsernameManagement($id){
    $users = UserManagement::find()->where(['id'=>$id])->one();
    if (!empty($users)) {
      return $users->name;
    }else {
      return $users = null;
    }

  }

  //EDR use the french notation format instead of the ISO numeric format. USe in the import metal area
  public static function get_numberFormat($number){
    return number_format($number,2,',','.');
  }

  //edr default numeric formatting
  public static function retrieveFormat($number){
    return number_format($number,2);
  }

  //edr retrieve Investor information from Investor Model
  public static function retrieveInvestor($id){
    $invest = Investor::find()->where(['id'=>$id])->one();
    if (!empty($invest)) {
      return $invest->company_name;
    }else {
      return $invest = null;
    }
  }

  //edr retrieve the product information from ProductManagement Model
  public static function retrieveProductName($id){
    $prod = ProductManagement::find()->where(['id'=>$id])->one();
    if (!empty($prod)) {
      return $prod->product_name;
    }else{
      return $prod = null;
    }
  }

  //edr retrieve product category information from ProductCategory Model
  public static function retrieveProductCat($id){
    $cat = ProductCategory::find()->where(['id'=>$id])->one();
    if (!empty($cat)) {
       return $cat->category;
    }else {
      return $prod = null;
    }
  }

  //edr changed date format to m-d-y
  public static function retrieveDate_mdy($date){
    return date('m-d-Y',strtotime($date));
  }

}
?>
