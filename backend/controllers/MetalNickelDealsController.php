<?php

namespace backend\controllers;

use Yii;
use common\models\MetalNickelDeals;
use common\models\CountryMetalNickelDealsSearch;
use common\models\ProductManagement;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MetalNickelDealsController implements the CRUD actions for MetalNickelDeals model.
 */
class MetalNickelDealsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MetalNickelDeals models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CountryMetalNickelDealsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MetalNickelDeals model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MetalNickelDeals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MetalNickelDeals();
        $model->date_uploaded = date('Y-m-d');
        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->contract_period_start = $this->convertDateFormat($model->contract_period_start,'Y-m-d');
            $model->contract_period_end = $this->convertDateFormat($model->contract_period_end,'Y-m-d');
            $model->unrealised_profit_a = $model->unrealised_profit_a/100;
            $model->commission_per = $model->commission_per/100;
            $prods = new ProductManagement();
            $prods->addProduct($model->title,3);
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        //  print_r($model->getErrors());
        //  die();
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MetalNickelDeals model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->contract_period_start = $this->convertDateFormat($model->contract_period_start,'d M Y');
        $model->contract_period_end = $this->convertDateFormat($model->contract_period_end,'d M Y');
        $model->unrealised_profit_a = $model->unrealised_profit_a*100;
        $model->commission_per = $model->commission_per*100;
        //$model->total_cost_price = number_format()
        $model->setFormat();
        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->contract_period_start = $this->convertDateFormat($model->contract_period_start,'Y-m-d');
            $model->contract_period_end = $this->convertDateFormat($model->contract_period_end,'Y-m-d');
            $model->unrealised_profit_a = $model->unrealised_profit_a/100;
            $model->commission_per = $model->commission_per/100;
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MetalNickelDeals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    public function actionAjaxSum(){
      if (Yii::$app->request->post() ) {
          $ins = Yii::$app->request->post()['pur_price'];
          $pur = Yii::$app->request->post()['ins_price'];
          $total = $ins + $pur;

          return number_format($total,2);

      }

    }

    public function actionAjaxCommission(){
      if (Yii::$app->request->post() ) {
          $ins = Yii::$app->request->post()['pur_price'];
          $pur = Yii::$app->request->post()['ins_price'];
          $for = Yii::$app->request->post()['for_price'];
          $final_percent = Yii::$app->request->post()['final_percent'];
          $com_per = Yii::$app->request->post()['com_per'];
      //    return number_format($total,2);
          $total = $ins + $pur;
          $final_percent = $final_percent/100;
          $true_percent = 1 - $final_percent;
          $com_per = $com_per/100;

          $final_sales_price = $for*$true_percent;
          $before_commission = $final_sales_price - $total; //Realised Profit before Commission
          $before_com_per = ($before_commission/$total)*100;//Realised Profit before Commission percentage
        //  $commission  =$before_commission*0.15; //Commission
          $commission  =$before_commission*$com_per; //Commission
          $after_commission = $before_commission-$commission;//Realised Profit after Commission
          $net_realized = ($after_commission/$total)*100;//Net Realised Percentage Returns


        //  return $true_percent;
        //  die('test');
        echo json_encode(array(
        //  'before_commission'=>number_format($before_commission,2),
          'before_commission'=>number_format($before_com_per,4),
          'commission'=>number_format($commission,2),
          'after_commission'=>number_format($after_commission,2),
          'net_realized'=>number_format($net_realized,2),
        ));

      }

    }


    protected function convertDateFormat($dates,$code){
        $date = new \DateTime($dates);
        if ($code == 'Y-m-d') {
          return $date->format('Y-m-d');
        }else{
          return $date->format('d M Y');
        }

    }

  /*  protected function convertToMurica($dates){
      $date = new \DateTime($dates);
      return $date->format('Y-m-d');
    }*/

    /**
     * Finds the MetalNickelDeals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MetalNickelDeals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MetalNickelDeals::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
