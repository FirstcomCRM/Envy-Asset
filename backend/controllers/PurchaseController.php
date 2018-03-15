<?php

namespace backend\controllers;

use Yii;
use common\models\Purchase;
use common\models\PurchaseSearch;
use common\models\UserPermission;
use common\models\User;
use common\models\UserGroup;
use common\models\UserManagement;
use common\models\Investor;
use common\models\Commission;
use common\models\TierReduction;
use common\models\MetalUnrealisedGain;
use common\models\PurchaseEarning;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class PurchaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
      foreach ( $userGroupArray as $uGId => $uGName ){
          $permission = UserPermission::find()->where(['controller' => 'Purchase'])->andWhere(['user_group_id' => $uGId ] )->all();
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

    /**
     * Lists all Purchase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Purchase model.
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
     * Creates a new Purchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Purchase();
        $model->date = date('d M Y');
        $model->purchase_type = 'Metal';
        $model->company_charge = 0.00;
        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->date = date('Y-m-d', strtotime($model->date) );
            $model->expiry_date = date('Y-m-d', strtotime($model->expiry_date) );
            $model->date_added = date('Y-m-d h:i:s');
            $model->company_charge = $model->company_charge/100;
          //    $model->Quo_ID = $quo = 'QUO-'. sprintf("%007d", $model->ID);
            $start = date('Y-m-01',strtotime($model->date) );
            $start = strtotime($start);
            $end = date('Y-m-01',strtotime($model->expiry_date) );
            $end = strtotime($end);

            $model->save(false);
            $model->purchase_no = date('Ym').'-'.sprintf("%005d", $model->id);
            $model->save(false);

            while ($start<=$end) {
              $date_test =  date('Y-m-d', $start);
          //    $this->commission($date_test,$model->getAttributes() );
              $this->earning($date_test,$model->getAttributes() );
              $start = strtotime("+1month", $start);
            }

            Yii::$app->session->setFlash('success', "Purchase added");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Purchase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->date = date('d M Y', strtotime($model->date) );
        $model->expiry_date = date('d M Y', strtotime($model->expiry_date) );
        $model->company_charge = $model->company_charge*100;
        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {

            $model->date = date('Y-m-d', strtotime($model->date) );
            $model->expiry_date = date('Y-m-d', strtotime($model->expiry_date) );
            $model->company_charge = $model->company_charge/100;

            $model->save(false);
            Yii::$app->session->setFlash('success', "Purchase updated");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Purchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

   public function actionAjaxSum(){
      $multiplier = 0;
      $namount= 0;
      $customer_amount = 0;
      $staff_earn = 0;
       if ( Yii::$app->request->post() ) {
            $amount = Yii::$app->request->post()['price'];
            $expiry_date = Yii::$app->request->post()['expiry_date'];
            $data = new \DateTime($expiry_date);
            $expire = $data->format('Y-m-d');
            $purchase_date = Yii::$app->request->post()['purchase_date'];
            $data = new \DateTime($purchase_date);
            $purchase = $data->format('Y-m-01');

            $charge_type = Yii::$app->request->post()['charge_type'];
            $purchase_type = Yii::$app->request->post()['purchase_type'];
            $com_charge = Yii::$app->request->post()['company_charge'];
            $com_charge = $com_charge/100;

            //$metal = MetalUnrealisedGain::find()->where(['between','date_uploaded',$purchase,$expire])->sum('re_gain_loss');
            $metal = MetalUnrealisedGain::find()->where(['between','true_date',$purchase,$expire])->sum('re_gain_loss');

            if (empty($metal) ) {
              $multiplier = 0.00;
            }else{
              $multiplier = $metal;
            }

            if ($purchase_type =='Metal' && $charge_type == 'Others') {
            //  print_r($charge_type.'-'.$purchase_type);
              $customer_amount  = ($amount*$multiplier); //customer earn
            //  $namount = ($customer_amount*$com_charge); //company earn
              $company_earn = ($customer_amount*$com_charge); //company earn
              $staff_earn = $company_earn/2; //staff earn
            }else{
          //  print_r('--');
            //  $namount = $amount*$multiplier;
            //  $company_earn = $amount*$multiplier;
              $company_earn =0;
              $customer_amount = 0;
              $staff_earn = 0;
            }
              //return number_format($namount,2);
              echo json_encode(array(
                'customer_amount'=>number_format($customer_amount,2),
                'company_earn'=>number_format($company_earn,2),
                'staff_earn'=>number_format($staff_earn,2),
              ));
       }
   }

    /**
     * Finds the Purchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
    *Protected function that creates a new comission record based on the loop  in the create function.
    */
    protected function comms($xid,$highest,$model){
        $comm = new Commission();
        $comm->transact_id = $model->id;
        $comm->transact_no = $model->purchase_no;
        $comm->transact_type = 'Purchase';
        $comm->transact_amount = $model->price; //questionable?
        $comm->transact_date =$model->date;
        $comm->sales_person = $xid;
        $comm->commision_percent = $highest;
        $comm->commission = $comm->commision_percent * $comm->transact_amount;
        $comm->date_added = date('Y-m-d h:i:s');
        $comm->save();
    }

    protected function earning($date_test,$model){
      $namount= 0;
      $customer_amount = 0;
      $staff_earn = 0;

      $comm = MetalUnrealisedGain::find()->where(['true_date'=>$date_test])->one();
      if (empty($comm) ) {
        $multiplier = 0;
        //$date_re = null;
        $date_re = $date_test;
      }else{
        $multiplier = $comm->re_gain_loss;
        $date_re = $comm->true_date;
      }
    //  print_r($multiplier);die();
      $earning = new PurchaseEarning();
      $earning->purchase_id = $model['id'];
      $earning->purchase_date = $model['date'];
      $earning->expiry_date = $model['expiry_date'];
      $earning->purchase_amount = $model['price'];
      $earning->re_date = $date_re;
      $earning->re_metal_per = $multiplier;

      if ($model['charge_type']=='Others' && $model['purchase_type'] =='Metal') {
      //  $customer_amount  = ($new_comm->transact_amount*$multiplier);
      //  $new_comm->commission_comp = ($customer_amount*$model['company_charge']);
          $earning->customer_earn = $earning->purchase_amount*$multiplier;
          $earning->company_earn = $earning->customer_earn*$model['company_charge'];
          $earning->staff_earn = $earning->company_earn/2;
      }else{
          $earning->customer_amount = 0;
          $earning->company_earn  = 0;
          $earning->staff_earn  = 0;
      //  $new_comm->commission_comp = $new_comm->transact_amount*$multiplier;
      }

      $earning->save(false);
    }

    //edr disabled temporarily. if useless, get rid of it
  /*  protected function commission($date_test,$model){
  //   echo '<pre>';
    //  print_r($date_test );die();
        $comm = MetalUnrealisedGain::find()->where(['true_date'=>$date_test])->one();
        if (empty($comm) ) {
          $multiplier = 0;
          $date_re = null;
        }else{
          $multiplier = $comm->re_gain_loss;
          $date_re = $comm->date_uploaded;
        }
      //  print_r($multiplier);die();
        $new_comm = new Commission();
        $new_comm->transact_id = $model['id'];
        $new_comm->transact_no = $model['purchase_no'];
        $new_comm->re_month = $date_re;
        $new_comm->transact_type = 'Purchase Investor';
        $new_comm->transact_amount = $model['price'];
        $new_comm->transact_date =$model['date'];
        $new_comm->sales_person = $model['salesperson'];
        $new_comm->commision_percent = $multiplier;

        if ($model['charge_type']=='Others' && $model['purchase_type'] =='Metal') {
          $customer_amount  = ($new_comm->transact_amount*$multiplier);
          $new_comm->commission_comp = ($customer_amount*$model['company_charge']);
        }else{
          $new_comm->commission_comp = $new_comm->transact_amount*$multiplier;
        }
        $new_comm->commission = $new_comm->commission_comp/2;
        //$new_comm->commission = ($new_comm->commision_percent * $new_comm->transact_amount);
        //$new_comm->commission_comp = $new_comm->commission/2;

        $new_comm->date_added = date('Y-m-d h:i:s');
        $new_comm->date_expire = $model['expiry_date'];
        $new_comm->save(false);
    //    echo '<pre>';
    //    print_r($model);die();
  }*/
}
