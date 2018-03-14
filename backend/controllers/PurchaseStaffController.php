<?php

namespace backend\controllers;

use Yii;
use common\models\PurchaseStaff;
use common\models\PurchaseStaffSearch;
use common\models\UserPermission;
use common\models\User;
use common\models\UserGroup;
use common\models\UserManagement;
use common\models\MetalUnrealisedGain;
use common\models\Commission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * PurchaseStaffController implements the CRUD actions for PurchaseStaff model.
 */
class PurchaseStaffController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
      foreach ( $userGroupArray as $uGId => $uGName ){
          $permission = UserPermission::find()->where(['controller' => 'PurchaseStaff'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all PurchaseStaff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseStaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseStaff model.
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
     * Creates a new PurchaseStaff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurchaseStaff();
        $model->date = date('d M Y');
        $model->purchase_type = 'Metal';
        $model->company_charge = 0.00;

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->date = date('Y-m-d', strtotime($model->date) );
            $model->expiry_date = date('Y-m-d', strtotime($model->expiry_date) );
            $model->date_added = date('Y-m-d h:i:s');
            $model->company_charge = $model->company_charge/100;

            $start = date('Y-m-01',strtotime($model->date) );
            $start = strtotime($start);
            $end = date('Y-m-01',strtotime($model->expiry_date) );
            $end = strtotime($end);

            $model->save(false);
            $model->purchase_no = date('Ym').'-'.sprintf("%005d", $model->id);
            $model->save(false);

            while ($start<=$end) {
              $date_test =  date('Y-m-d', $start);
              $this->commission($date_test,$model->getAttributes() );
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
     * Updates an existing PurchaseStaff model.
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
     * Deletes an existing PurchaseStaff model.
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
       $multiplier = 0;
       $namount= 0;
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

             $metal = MetalUnrealisedGain::find()->where(['between','date_uploaded',$purchase,$expire])->sum('re_gain_loss');
             if (empty($metal) ) {
               $multiplier = 0.00;
             }else{
               $multiplier = $metal;
             }

             if ($purchase_type =='Metal' && $charge_type == 'Others') {
             //  print_r($charge_type.'-'.$purchase_type);
               $customer_amount  = ($amount*$multiplier);
               $namount = ($customer_amount*$com_charge);
             }else{
           //  print_r('--');
               $namount = $amount*$multiplier;
             }


               return number_format($namount,2);

        }
    }


    /**
     * Finds the PurchaseStaff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseStaff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseStaff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    protected function commission($date_test,$model){
  //   echo '<pre>';
    //  print_r($date_test );die();
        $comm = MetalUnrealisedGain::find()->where(['date_uploaded'=>$date_test])->one();
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
        $new_comm->transact_type = 'Purchase Staff';
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
    }


}
