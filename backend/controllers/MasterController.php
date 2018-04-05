<?php

namespace backend\controllers;

use Yii;

class MasterController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTruncatePurchase(){
      //die('working');
      Yii::$app->db->createCommand()->truncateTable('purchase')->execute();
      Yii::$app->db->createCommand()->truncateTable('purchase_earning')->execute();
      Yii::$app->session->setFlash('success',"Purchase Truncate Successful");
      return $this->redirect(['index']);
    }

    public function actionTruncateMetal(){
      Yii::$app->db->createCommand()->truncateTable('import_metal')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_al')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_au')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_cu')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_ni')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_nickel_deals')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_oil')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_unrealised')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_unrealised_gain')->execute();
      Yii::$app->db->createCommand()->truncateTable('metal_zn')->execute();
      Yii::$app->session->setFlash('success',"Metal Truncate Successful");
      return $this->redirect(['index']);
    }

    public function actionTruncateWithdraw(){
      Yii::$app->db->createCommand()->truncateTable('withdraw')->execute();
    // /  Yii::$app->db->createCommand()->truncateTable('metal_al')->execute();
      Yii::$app->session->setFlash('success',"Withdraw Truncate Successful");
      return $this->redirect(['index']);
    }

    public function actionTruncateStocks(){
      Yii::$app->db->createCommand()->truncateTable('stocks')->execute();
    //  Yii::$app->db->createCommand()->truncateTable('metal_al')->execute();
      Yii::$app->session->setFlash('success',"Stocks Truncate Successful");
      return $this->redirect(['index']);
    }

    public function actionTruncateProduct(){
      Yii::$app->db->createCommand()->truncateTable('product_management')->execute();
    //  Yii::$app->db->createCommand()->truncateTable('metal_al')->execute();
      Yii::$app->session->setFlash('success',"Product Truncate Successful");
      return $this->redirect(['index']);
    }



}
