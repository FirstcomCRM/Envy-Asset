<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Purchase;
use common\models\MetalNickelDeals;

class CronController extends Controller
{

    public function actionIndex()
    {
      //  return $this->render('index');
      $fp=fopen("console/controllers/testfile.txt", "w");
      fwrite($fp,'testsss');
      fclose($fp);
    }

    public function actionTest(){
      $fp=fopen("console/controllers/testfile.txt", "w");
      fwrite($fp,'test New Test');
      fclose($fp);
      echo 'file created';
    }

    public function actionNickel(){
      $now = new \DateTime();
      $date = $now->format('Y-m-d');
      //echo $date;
      $multiplier = 0;
    //  $date = '2018-03-31';

      $data = Purchase::find()->where(['expiry_date'=>$date, 'purchase_type'=>'Nickel', 'charge_type'=>'Others'])->orderBy(['id'=>SORT_ASC])->all();
      $re = MetalNickelDeals::find()->where(['contract_period_end'=>$date])->one();
      if (!empty($re)) {
        $multiplier = $re->unrealised_profit_a;
      }
      //echo $multiplier;

      if (!empty($data) ) {
        foreach ($data as $k => $v) {
          $v->customer_earn = $v->price * $multiplier;
          $v->company_earn = $v->customer_earn*$v->company_charge;
          $v->staff_earn = $v->company_earn/2;
          $v->save(false);
          //echo $v->customer_earn.'-'.$v->company_earn;
          //echo 'save trigered on'.$v->id;
        }
    //    $data->customer_earn = $date->customer_earn * $multiplier;
      }

    //  $fp=fopen("console/controllers/testfile.txt", "w");
  //fwrite($fp,'Write Successful');
  //fclose($fp);
        echo 'Run successful';
    }

}
