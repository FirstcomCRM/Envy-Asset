<?php

namespace backend\controllers;

use Yii;
use mPDF;
use common\models\User;
use common\models\UserGroup;
use common\models\UserManagement;
use common\models\UserPermission;
use common\models\Purchase;
use common\models\PurchaseSearch;
use common\models\Investor;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class InvestorReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
      $searchModel = new PurchaseSearch();
      $dataProvider = $searchModel->report_search(Yii::$app->request->queryParams);
      $session = Yii::$app->session;
      if (!$session->isActive) {
          $session->open();
      }
      $session['investor-report'] = Yii::$app->request->queryParams;
    //  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
    }

    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          //return $this->redirect(['index']);die();
          //die('test11');
        //  return $this->redirect(['view', 'id' => $model->id]);
      } else {
          //die('test');
          return $this->renderAjax('update', [
              'model' => $model,
          ]);
      }
    }

    public function actionGetSales($id){
      // $data = Investor::find()->where(['id'=>$id])->one();
      //die($id);
        //die($id);
       $find = Investor::find()->where(['id'=>$id])->one();
       $sales = UserManagement::find()->where(['id'=>$find->salesperson])->one();
       //echo $sales->name;
       if (!empty($sales)) {
          echo "<option value='".$sales->id."'>".$sales->name."</option>";

       }else{
           echo "<option>N/A</option>";
       }
   }

   public function actionComposeEmail(){
       ini_set('max_execution_time', 180);
       ini_set("memory_limit", "512M");
       $searchModel = new PurchaseSearch();
       $dataProvider = $searchModel->report_search(Yii::$app->session->get('investor-report'));

       $newDate = date('M-Y',strtotime($searchModel->start));
       $title = 'Investor Report '.$newDate;


       $mpdf = new mPDF('utf-8','A3-L');
       $mpdf->content = $this->renderPartial('report-pdf',[
          'searchModel'=>$searchModel,
          'dataProvider' => $dataProvider,
        ]);
        $mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($mpdf->content);
        $attach = $mpdf->Output('','S');
        foreach ($dataProvider->getModels() as $key => $value) {
          $cust = Investor::find()->where(['id'=>$value->investor])->one();
          if (!empty($cust)) {
            $toArray[] = $cust->email;
          }
        }

        $message = "<p>Greetings,</p>";
        $message .= '<p>Please find attached file.</p>';
        $message .= '<p>Thank you.</p>';
        $testcc = 'eumerjoseph.ramos@yahoo.com';
        Yii::$app->mailer->compose()
        ->setTo($toArray)
      //  ->setFrom([$eng->email => $eng->fullname])
        ->setFrom(['no-reply@envy.cc' => 'no-reply@envy.cc'])
        ->setCc($testcc) //temp
        ->setSubject('Investor Report')
        ->setHtmlBody($message)
    //    ->setReplyTo([$eng->email])
        ->attachContent($attach,['fileName'=>$title.'.pdf','contentType' => 'application/pdf'])
        ->send();
        Yii::$app->session->setFlash('success', "Email sent");
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
      //  print_r(array_unique($toArray));
      //  foreach (array_unique($toArray) as $key => $value) {
        //  echo $value.'<br>';
        //}


        //$mpdf->Output($title.'.pdf','I');
        //exit;
   }

    protected function findModel($id)
    {
        if (($model = Purchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
