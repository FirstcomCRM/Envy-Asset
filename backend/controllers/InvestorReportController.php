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
use common\models\InvestorSearch;
use common\components\Retrieve;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class InvestorReportController extends \yii\web\Controller
{

  public function behaviors()
  {
    $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
    foreach ( $userGroupArray as $uGId => $uGName ){
        $permission = UserPermission::find()->where(['controller' => 'InvestorReport'])->andWhere(['user_group_id' => $uGId ] )->all();
        $actionArray = [];
        foreach ( $permission as $p )  {
            $actionArray[] = $p->action;
        }

        $allow[$uGName] = false;
        $action[$uGName] = $actionArray;
        if ( ! empty( $action[$uGName] ) ) {
            $allow[$uGName] = true;
        }

    }

    $usergroup_id = User::find()->where(['id'=>Yii::$app->user->id])->one();

    if (!empty($usergroup_id)) {
      return [
          'access' => [
              'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view', 'delete'],
              'rules' => [
                    [
                        'actions' => $action[$usergroup_id->user_group_id],
                        'allow' => $allow[$usergroup_id->user_group_id],
                        'roles' => [$usergroup_id->user_group_id],
                    ],
                  ],
                  'denyCallback' => function ($rule, $action) {
                      throw new \yii\web\HttpException(403, 'Error! You are forbidden to use this module. Please contact System Admin for more information.');
                    }

          ],
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'logout' => ['post'],
              ],
          ],
      ];
    }else{
      return [
          'access' => [
              'class' => AccessControl::className(),
              'rules' => [
                  [
                      'actions' => ['login', 'error'],
                      'allow' => true,
                  ],
                  [
                      'actions' => ['logout', 'index'],
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
          ],
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'logout' => ['post'],
              ],
          ],
      ];
    }
  }


    public function actionIndex()
    {
      $searchModel = new PurchaseSearch();

      $request = Yii::$app->request;

      $session = Yii::$app->session;
      if (!$session->isActive) {
          $session->open();
      }

      $test = $request->get();
      if (array_key_exists('PurchaseSearch', $test)) {

      }else{
          $searchModel->dummy_id = 0;
      }

      $dataProvider = $searchModel->report_search(Yii::$app->request->queryParams);

      $session['investor-report'] = Yii::$app->request->queryParams;
    //  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'test'=>$test,
      ]);
    }

//temporary
    public function actionAlter(){
        $searchModel = new InvestorSearch();

        $request = Yii::$app->request;

        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }
        $test = $request->get();
        if (array_key_exists('InvestorSearch', $test)) {
          //die('work');
        }else{
            $searchModel->id = 0;
        }

        //print_r($test);die();

        $dataProvider = $searchModel->alterSearch(Yii::$app->request->queryParams);

        $session['alter-report'] = Yii::$app->request->queryParams;
        return $this->render('alter', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'test'=>$test,
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

   /*
   *Function to send all investors in the result list an email, together with their CCs???
   */
   public function actionComposeEmail(){
       ini_set('max_execution_time', 180);
       ini_set("memory_limit", "512M");
       $searchModel = new PurchaseSearch();
       $dataProvider = $searchModel->report_search(Yii::$app->session->get('investor-report'));

       $newDate = date('M-Y',strtotime($searchModel->start));
       $title = 'Investor Report '.$newDate;

       $mpdf = new mPDF('utf-8','A3');
       $mpdf->content = $this->renderPartial('row-pdf',[
           'searchModel'=>$searchModel,
        ]);
        $mpdf->setFooter('|GROWTH - CONSISTENCY - ETHICS|{PAGENO}');
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
     // $testcc = 'jasonchong@firstcom.com.sg';
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
        Yii::$app->session->setFlash('success', "Email sent to all investor");
        return $this->redirect(['index']);

   }

   public function actionDownloadPdf($id, $type=null){
     $model = $this->findModel($id);
     $searchModel = new PurchaseSearch();
     $dataProvider =  $searchModel->report_search(Yii::$app->session->get('investor-report'));
     //$newDate = date('M-Y',strtotime($searchModel->start));
     $invest = Retrieve::retrieveInvestor($model->investor);
     $data = Purchase::find()->where(['id'=>$id])->one();
     $pur_date = date('d M Y', strtotime($data->date));

     $title = $invest.'-'.$pur_date;

    // $mpdf = new mPDF('utf-8','A4');
      $mpdf = new mPDF('utf-8','A3');
     $mpdf->content = $this->renderPartial('row-pdf',[
        'model'=>$model,
        'searchModel'=>$searchModel,
      ]);
      $mpdf->setFooter('|GROWTH - CONSISTENCY - ETHICS|{PAGENO}');
      $mpdf->WriteHTML($mpdf->content);
      if ($type=='email') {
        $attach = $mpdf->Output('','S');
        $this->singleEmail($model,$attach,$title);
        Yii::$app->session->setFlash('success', "Email sent");
        return $this->redirect(['d-index']);
      }else{
      //  $mpdf->Output($title.'.pdf','D');
        $mpdf->Output($title.'.pdf','I');
        exit();
      }
   }

     public function actionAlterDownload($id){
        $model =Investor::findOne($id);
      //  print_r($model);die();
       $searchModel = new InvestorSearch();
       $searchModel->alterSearch(Yii::$app->session->get('alter-report'));
    //   print_r($searchModel->date_filter);die();
        $title = $model->company_name.'-'.$searchModel->date_filter;
       $mpdf = new mPDF('utf-8','A3');
       $mpdf->content = $this->renderPartial('alter-pdf',[
           'model'=>$model,
          'searchModel'=>$searchModel,
        ]);
        $mpdf->setFooter('|GROWTH - CONSISTENCY - ETHICS|{PAGENO}');
        $mpdf->WriteHTML($mpdf->content);
        $mpdf->Output($title.'.pdf','I');

        exit();

     }

   public function actionAlterEmail(){
     // /die('test');
      if ( Yii::$app->request->post() ) {
        $searchModel = new InvestorSearch();
        if (is_array(Yii::$app->request->post()['keys']) ) {
          $ids = Yii::$app->request->post()['keys'];

        }else{
          $ids = [];
          $ids[] = Yii::$app->request->post()['keys'];

        }

        $date_filter = Yii::$app->request->post()['dates'];
        $searchModel->date_filter = date('Y-m-d',strtotime($date_filter) );
        foreach ($ids as $key => $value) {
          $model =Investor::findOne($value);
          $title = $model->company_name.'-'.$date_filter;
          $mpdf = new mPDF('utf-8','A3');
          $mpdf->content = $this->renderPartial('alter-pdf',[
              'model'=>$model,
              'searchModel'=>$searchModel,
           ]);
           $mpdf->setFooter('|GROWTH - CONSISTENCY - ETHICS|{PAGENO}');
           $mpdf->WriteHTML($mpdf->content);
           $attach = $mpdf->Output("{$title}.pdf",'S');

           $message = "<p>Greetings,</p>";
           $message .= '<p>Please find attached file.</p>';
           $message .= '<p>Thank you.</p>';
      //     $testcc = 'eumerjoseph.ramos@yahoo.com';
           Yii::$app->mailer->compose()
           ->setTo($model->email)
         //  ->setFrom([$eng->email => $eng->fullname])
           ->setFrom(['no-reply@envy.cc' => 'no-reply@envy.cc'])
           //->setCc($testcc) //temp
           ->setSubject($title)
           ->setHtmlBody($message)
       //    ->setReplyTo([$eng->email])
           ->attachContent($attach,['fileName'=>$title.'.pdf','contentType' => 'application/pdf'])
           ->send();

        }

      }

    }

   public function actionDIndex(){
     $searchModel = new PurchaseSearch();
     $dataProvider =  $searchModel->report_search(Yii::$app->session->get('investor-report'));

     return $this->render('d-index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
     ]);
   }

  /*
  *Email function that sends an email notification to one investor, together with their email_cc
  */
   protected function singleEmail($model,$attach,$title){
  //   die('email');
     $cust = Investor::find()->where(['id'=>$model->investor])->one();
     $ccs = explode(",",$cust->email_cc);

     foreach ($ccs as $key => $value) {
       $testcc[] = trim($value);
     }

     $message = "<p>Greetings,</p>";
     $message .= '<p>Please find attached file...</p>';
     $message .= '<p>Thank you.</p>';
     //$testcc = 'eumerjoseph.ramos@yahoo.com';
    // $testcc = $ccs;
     Yii::$app->mailer->compose()
     ->setTo($cust->email)
   //  ->setFrom([$eng->email => $eng->fullname])
     ->setFrom(['no-reply@envy.com' => 'no-reply@envy.com'])
     ->setCc($testcc) //temp
     ->setSubject('Investor Report')
     ->setHtmlBody($message)
 //    ->setReplyTo([$eng->email])
     ->attachContent($attach,['fileName'=>$title.'.pdf','contentType' => 'application/pdf'])
     ->send();

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
