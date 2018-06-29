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
use common\models\MetalNickelDeals;
use common\models\ProductManagement;
use common\models\PurchaseLine;
use common\models\PurchaseLineSearch;
use common\models\Model;
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
        $line = new PurchaseLineSearch();
        $line->purchase_id = $id;
        $dataProvider_line = $line->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider_line'=>$dataProvider_line
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
        $modelLine = [new PurchaseLine];
        $model->setDefaults();
        if ($model->load(Yii::$app->request->post())  ) {
            $model->company_charge = $model->company_charge/100;
          //    $model->Quo_ID = $quo = 'QUO-'. sprintf("%007d", $model->ID);
            $start = date('Y-m-01',strtotime($model->date) );
            $start = strtotime($start);
            $end = date('Y-m-01',strtotime($model->metal_expiry_date) );
            $end = strtotime($end);

          //  print_r($model->nickel_date);die();
          /*  $model->save(false);
            $model->purchase_no = date('Ym').'-'.sprintf("%005d", $model->id);
            $model->save(false);*/

            $modelLine = Model::createMultiple(PurchaseLine::classname());
            Model::loadMultiple($modelLine, Yii::$app->request->post());
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelLine)&&  $valid;

          //  echo $model->ptotal_sold_unit; die();
            //print_r($valid);die();
            if ($model->purchase_type != 'Stocks') {
              $modelLine = [];
            }

            if ($valid) {

                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    if ($flag = $model->save(false)) {
                        $model->purchase_no = date('Ym').'-'.sprintf("%005d", $model->id);
                        $model->save(false);
                        foreach ($modelLine as $line)
                        {
                            $line->purchase_id = $model->id;
                            $line->psold_date = date('Y-m-d', strtotime($line->psold_date) );
                            if (! ($flag = $line->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }


                    }
                    if ($flag) {
                        $transaction->commit();
                        while ($start<=$end) {
                            $date_test =  date('Y-m-d', $start);
                        //    $this->commission($date_test,$model->getAttributes() );
                            $this->earning($date_test,$model->getAttributes() );
                          //  $model->earning($date_test);
                            $start = strtotime("+1month", $start);
                        }
                        //print_r($model->company_charge);
                        //die();
                        Yii::$app->session->setFlash('success', "Purchase created");
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }else{
              echo '<pre>';
              var_dump($modelLine);
              die();
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelLine'=> (empty($modelLine)) ? [new PurchaseLine] : $modelLine,
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
        $modelLine = PurchaseLine::find()->where(['purchase_id' => $id])->all();

        $model->date = date('d M Y', strtotime($model->date) );
        $model->metal_expiry_date = date('d M Y', strtotime($model->metal_expiry_date) );
        $model->company_charge = $model->company_charge*100;
        $model->nickel_date = date('d M Y', strtotime($model->nickel_date) );
        $model->nickel_expiry = date('d M Y', strtotime($model->nickel_expiry) );

        if ($model->load(Yii::$app->request->post())  ) {

          //  $model->ptotal_sold_unit = str_replace(",","",$model->ptotal_sold_unit);
          //  $model->date = date('Y-m-d', strtotime($model->date) );
      //      $model->true_expiry_date = date('Y-m-d', strtotime($model->true_expiry_date) );
        //    $model->nickel_date = date('Y-m-d', strtotime($model->nickel_date) );
        //    $model->nickel_expiry= date('Y-m-d', strtotime($model->nickel_expiry) );
            $model->company_charge = $model->company_charge/100;

            $oldIDs = ArrayHelper::map($modelLine, 'id', 'id');
            $purline = Model::createMultiple(PurchaseLine::classname(), $modelLine);
            Model::loadMultiple($purline, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($purline, 'id', 'id')));

            $valid = $model->validate();
            $valid = Model::validateMultiple($purline)&&  $valid;

            if ($model->purchase_type != 'Stocks') {
              $purline = [];
            }
            //echo '<pre>';
            //print_r($modelLine);die();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
              try {

                if ($flag = $model->save(false)) {
                    if (! empty($deletedIDs)) {
                      PurchaseLine::deleteAll(['id' => $deletedIDs]);
                    }

                foreach ($purline as $line) {
                    $line->purchase_id = $model->id;

                    $line->psold_date = date('Y-m-d', strtotime($line->psold_date) );
                    if (! ($flag = $line->save(false))) {
                        $transaction->rollBack();
                        break;
                      }
                    }

                }
                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Purchase updated");
                    return $this->redirect(['view', 'id' => $model->id]);
                }

              } catch (Exception $e) {
                  $transaction->rollBack();
              }
            }else{
              echo '<pre>';
              print_r($model);
              die();
            }



          //  $model->save(false);
          //  Yii::$app->session->setFlash('success', "Purchase updated");
          //  return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelLine'=> (empty($modelLine)) ? [new PurchaseLine] : $modelLine,
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

        $sales= null;
        $find = Investor::find()->where(['id'=>$id])->one();

       if (!empty($find->salesperson)) {
         $sales = UserManagement::find()->all();
          //$sales = UserManagement::find()->where(['id'=>$find->salesperson])->one();
          foreach ($sales as $key => $value) {
              if ($value->id == $find->salesperson) {
                  echo "<option value='".$value->id."' selected>".$value->name."</option>";
              }else{
                echo "<option value='".$value->id."'>".$value->name."</option>";
              }
            }


       }else{
           $sales = UserManagement::find()->all();
        //   print_r($sales);die();
           foreach ($sales as $key => $value) {
             echo "<option value='".$value->id."'>".$value->name."</option>";
           }
        //   echo "<option>N/A</option>";
       }
   }

   public function actionAjaxInvestor(){
     $data = 0;
     if ( Yii::$app->request->get() ) {
       $types = Yii::$app->request->get()['types'];
       if ($types == 'Investor') { //type investor
         $data = Investor::find()->orderBy(['company_name'=>SORT_ASC])->select(['id','nric_comp'])->all();
         foreach ($data as $key => $value) {
           echo "<option value='".$value->id."'>".$value->nric_comp."</option>";
         }
       }else{//type Staff
         $data = UserManagement::find()->all();
         foreach ($data as $key => $value) {
           echo "<option value='".$value->id."'>".$value->name."</option>";
         }
       }

      //  die($types);

     }
   }

   public function actionAjaxProduct(){
     if ( Yii::$app->request->post() ) {
       $ptype = Yii::$app->request->post()['ptype'];

       if ($ptype == 'Metal') {
         $data = ProductManagement::find()->select(['id','product_name'])->where(['invest_type'=>2])->asArray()->all();
       }elseif($ptype == 'Nickel'){
         $data = ProductManagement::find()->select(['id','product_name'])->where(['invest_type'=>3])->asArray()->all();
       }else{
         $data = ProductManagement::find()->select(['id','product_name'])->where(['invest_type'=>1])->asArray()->all();
       }
       $json = [];
       foreach ($data as $key => $value) {
         $json[$value['id']] = $value['product_name'];
       }

       return json_encode($json);
     }
   }

   public function actionAjaxSum(){
      $multiplier = 0;
      $namount= 0;
      $tier_charge = 0;
      $customer_amount = 0;
      $company_earn = 0;
      $staff_earn = 0;
      $arr_customer_earn = [];
      $arr_comapny_earn = [];
      $arr_staff_earn = [];
      $ncustomer_earn = 0;
      $ncompany_earn = 0;
      $nstaff_earn = 0;
      $sold_price_amount = 0;
       if ( Yii::$app->request->post() ) {
            $amount = Yii::$app->request->post()['price'];
          //  $sold_price = Yii::$app->request->post()['sold_price'];
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
            $trade_days =Yii::$app->request->post()['trade_days'];
            $rated_days = Yii::$app->request->post()['rated_days'];
            $product_id = Yii::$app->request->post()['products'];

            //$metal = MetalUnrealisedGain::find()->where(['between','date_uploaded',$purchase,$expire])->sum('re_gain_loss');
            $metal = MetalUnrealisedGain::find()->where(['between','true_date',$purchase,$expire])->sum('re_gain_loss');
            //edr add the nickel logic here to populate the fields via ajax
            if (empty($metal) ) {
              $multiplier = 0.00;
            }else{
              $multiplier = $metal;
            }

        //    print_r('test');die();

            $start = strtotime($purchase);
            $end = date('Y-m-01',strtotime($expire) );
            $end = strtotime($end);
            $tier_charge  =$com_charge;
            if ($charge_type == 'Others') {
              if ($purchase_type == 'Metal') {

                while ($start<=$end) {
                    $date_test =  date('Y-m-d', $start);

                    //
                    $comm = MetalUnrealisedGain::find()->where(['true_date'=>$date_test])->one();
                    if (empty($comm) ) {
                      $multiplier = 0;
                      //$date_re = null;
                      $date_re = $date_test;
                    }else{
                      $multiplier = $comm->re_gain_loss;
                      $date_re = $comm->true_date;
                    }
                    $compare_start =  date('Y-m-01',strtotime($purchase) );
                    $compare_end  = date('Y-m-01',strtotime($expire) );

                    if ($date_test == $compare_start || $date_test == $compare_end) {
                      //use trading and prorated days formula

                      $before_return = $amount*$multiplier;
                      $traded = $before_return/$trade_days;
                      $true_return = $traded*$rated_days;

                      $ncustomer_earn= $true_return;
                      $ncompany_earn = $ncustomer_earn*$com_charge;
                      $nstaff_earn = $ncompany_earn/2;

                    }else{
                      //common formula

                      $ncustomer_earn = $amount*$multiplier;
                      $ncompany_earn = $ncustomer_earn*$com_charge;
                      $nstaff_earn = $ncompany_earn/2;
                    }
                    //

                    $arr_customer_earn[]=$ncustomer_earn;
                    $arr_comapny_earn[]=$ncompany_earn;
                    $arr_staff_earn[] =$nstaff_earn;
                    $start = strtotime("+1month", $start);
                }

                $customer_amount = array_sum($arr_customer_earn);
                $company_earn = array_sum($arr_comapny_earn);
                $staff_earn = array_sum($arr_staff_earn);
                return json_encode(array(
                    'customer_amount'=>number_format($customer_amount, 2, '.' ,''),
                    'company_earn'=>number_format($company_earn,2,'.',''),
                    'staff_earn'=>number_format($staff_earn,2,'.',''),
                    'tier_charge'=>$tier_charge*100,
                ));

              }elseif ($purchase_type =='Nickel') {
                //charget type nickel others

                $current_date = date('Y-m-d', strtotime($purchase_date) );
                $nickel = MetalNickelDeals::find()->where(['product_id'=>$product_id])->one();
                if ($nickel->contract_period_end <= $current_date) {
                  $customer_amount = $amount*$nickel->unrealised_profit_a;
                  $company_earn =$customer_amount*$com_charge;
                  $staff_earn = $company_earn/2;
                }else{
                  $company_earn =0;
                  $customer_amount = 0;
                  $staff_earn = 0;
                }
                  $tier_charge = $com_charge;
              //  $company_earn =10;
              //  $customer_amount = 10;
              //  $staff_earn = 10;
                return json_encode(array(
                    'customer_amount'=>number_format($customer_amount, 2, '.' ,''),
                    'company_earn'=>number_format($company_earn,2,'.',''),
                    'staff_earn'=>number_format($staff_earn,2,'.',''),
                    'tier_charge'=>$tier_charge*100,
                ));
              }else{
                $company_earn =0;
                $customer_amount = 0;
                $staff_earn = 0;
                return json_encode(array(
                    'customer_amount'=>number_format($customer_amount, 2, '.' ,''),
                    'company_earn'=>number_format($company_earn,2,'.',''),
                    'staff_earn'=>number_format($staff_earn,2,'.',''),
                ));
              }
            }else{//charge type == 'Tier'

              if ($purchase_type == 'Metal') {

                $x = new Purchase();
                $tier_charge = $x->tierFunc($metal);
              //  $tier_charge = Purchase::tierFunc($metal);
                while ($start<=$end) {
                    $date_test =  date('Y-m-d', $start);

                    //
                    $comm = MetalUnrealisedGain::find()->where(['true_date'=>$date_test])->one();
                    if (empty($comm) ) {
                      $multiplier = 0;
                      //$date_re = null;
                      $date_re = $date_test;
                    }else{
                      $multiplier = $comm->re_gain_loss;
                      $date_re = $comm->true_date;
                    }
                    $compare_start =  date('Y-m-01',strtotime($purchase) );
                    $compare_end  = date('Y-m-01',strtotime($expire) );

                    if ($date_test == $compare_start || $date_test == $compare_end) {
                      //use trading and prorated days formula

                      $before_return = $amount*$multiplier;
                      $traded = $before_return/$trade_days;
                      $true_return = $traded*$rated_days;

                      $ncustomer_earn= $true_return;
                      $ncompany_earn = $ncustomer_earn*$tier_charge;
                      $nstaff_earn = $ncompany_earn/2;

                    }else{
                      //common formula

                      $ncustomer_earn = $amount*$multiplier;
                      $ncompany_earn = $ncustomer_earn*$tier_charge;
                      $nstaff_earn = $ncompany_earn/2;
                    }
                    //

                    $arr_customer_earn[]=$ncustomer_earn;
                    $arr_comapny_earn[]=$ncompany_earn;
                    $arr_staff_earn[] =$nstaff_earn;
                    $start = strtotime("+1month", $start);
                  }

                    $customer_amount = array_sum($arr_customer_earn);
                    $company_earn = array_sum($arr_comapny_earn);
                    $staff_earn = array_sum($arr_staff_earn);
                    return json_encode(array(
                        'customer_amount'=>number_format($customer_amount, 2, '.' ,''),
                        'company_earn'=>number_format($company_earn,2,'.',''),
                        'staff_earn'=>number_format($staff_earn,2,'.',''),
                        'tier_charge'=>$tier_charge*100,
                    ));


              }elseif ($purchase_type == 'Nickel') {
                $current_date = date('Y-m-d',strtotime($purchase_date) );
                $nickel = MetalNickelDeals::find()->where(['product_id'=>$product_id])->one();
                $x = new Purchase();
                $tier_charge = $x->tierFunc($nickel->unrealised_profit_a);
                  if ($nickel->contract_period_end <= $current_date) {
                    $customer_amount = $amount*$nickel->unrealised_profit_a;
                    $company_earn =$customer_amount*$tier_charge;
                    $staff_earn = $company_earn/2;
                  }else{
                    $company_earn =0;
                    $customer_amount = 0;
                    $staff_earn = 0;
                  }

                return json_encode(array(
                    'customer_amount'=>number_format($customer_amount, 2, '.' ,''),
                    'company_earn'=>number_format($company_earn,2,'.',''),
                    'staff_earn'=>number_format($staff_earn,2,'.',''),
                    'tier_charge'=>$tier_charge*100,
                ));
              }else{
                $company_earn =0;
                $customer_amount = 0;
                $staff_earn = 0;
                return json_encode(array(
                    'customer_amount'=>number_format($customer_amount, 2, '.' ,''),
                    'company_earn'=>number_format($company_earn,2,'.',''),
                    'staff_earn'=>number_format($staff_earn,2,'.',''),
                ));
              }
            }


       }
   }

   public function actionAjaxNickel(){
     $start = 0;
     $end = 0;
     $com_per = 0;
     if ( Yii::$app->request->post() ) {
          $product_id = Yii::$app->request->post()['product'];
          $charge_type = Yii::$app->request->post()['charge_type'];

          $nickel = MetalNickelDeals::find()->where(['product_id'=>$product_id])->one();

          if (!empty($nickel)) {
            $dates = new \DateTime($nickel->contract_period_start);
            $start = $dates->format('d M Y');
            $dates = new \DateTime($nickel->contract_period_end);
            $end = $dates->format('d M Y');
            if ($charge_type == 'Tier') {
              $com_per = $nickel->commission_per*100;
            }else{
              $com_per = 0;
            }

            return json_encode(array(
              'start'=>$start,
              'end'=>$end,
              'com_per'=>$com_per,
            ));
          //  $start = $nickel->contract_period_start;
          //  $expire =$nickel->contract_period_end;
          }else{
            return json_encode(array(
              'start'=>'',
              'end'=>'',
              'com_per'=>$com_per,
            ));
          }
     }
   }

   public function actionAjaxStockamount(){
     $amount = 0;
     if ( Yii::$app->request->post() ) {
        $unit = str_replace(",","",Yii::$app->request->post()['stocks_unit']);
        $price = str_replace(",","",Yii::$app->request->post()['stocks_price']);
      //  str_replace(",","",$model->ptotal_sold_unit);
        $amount = $unit*$price;
        return $amount;

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
      $earning->investor = $model['investor'];
      $earning->purchase_amount = $model['price'];
      $earning->ptype = $model['type'];
      $earning->re_date = $date_re;
      $earning->re_metal_per = $multiplier;

      if ($multiplier<=0.30) {
        $earning->tranche = 0.15;
      }elseif($multiplier>0.30 && $multiplier<=0.40){
        $earning->tranche = 0.18;
      }elseif ($multiplier>0.40 && $multiplier <=0.50) {
        $earning->tranche = 0.20;
      }else {
        $earning->tranche = 0.25;
      }


      $compare_start =  date('Y-m-01',strtotime($model['date']) );
      $compare_end  = date('Y-m-01',strtotime($model['metal_expiry_date']) );

      $metal = MetalUnrealisedGain::find()->where(['between','true_date',$compare_start,$compare_end])->sum('re_gain_loss');


      if ($model['charge_type'] == 'Others') {
        if ($model['purchase_type']== 'Metal') {

          if ($date_test == $compare_start || $date_test == $compare_end) {
            //use trading and prorated days formula
            $before_return = $model['price']*$multiplier;
            $traded = $before_return/$model['trading_days'];
            $true_return = $traded*$model['prorated_days'];
            $earning->customer_earn = $true_return;
            $earning->company_earn = $earning->customer_earn*$model['company_charge'];
            $earning->customer_earn_after = $earning->customer_earn - $earning->company_earn;
            $earning->staff_earn = $earning->company_earn/2;
          }else{
            //common formula
            $earning->customer_earn = $model['price']*$multiplier;
            $earning->company_earn = $earning->customer_earn*$model['company_charge'];
            $earning->customer_earn_after = $earning->customer_earn - $earning->company_earn;
            $earning->staff_earn = $earning->company_earn/2;
          }

        }elseif ($model['purchase_type']== 'Nickel') {
          $earning->customer_earn = 0;
          $earning->customer_earn_after = 0;
          $earning->company_earn  = 0;
          $earning->staff_earn  = 0;
        }else{//purchase type is stocks
          $earning->customer_earn = 0;
          $earning->customer_earn_after = 0;
          $earning->company_earn  = 0;
          $earning->staff_earn  = 0;
        }
      }else{//charge type == 'tier'
        if ($model['purchase_type']== 'Metal') {

          $x = new Purchase();
          $tier_charge = $x->tierFunc($metal);
        //  $tier_charge = Purchase::tierFunc($metal);
          //$multiplier = $tier_charge;

          //
          if ($date_test == $compare_start || $date_test == $compare_end) {
            //use trading and prorated days formula
            $before_return = $model['price']*$multiplier;
            $traded = $before_return/$model['trading_days'];
            $true_return = $traded*$model['prorated_days'];
            $earning->customer_earn = $true_return;
            $earning->company_earn = $earning->customer_earn*$tier_charge;
            $earning->customer_earn_after = $earning->customer_earn - $earning->company_earn;
            $earning->staff_earn = $earning->company_earn/2;
          }else{
            //common formula
            $earning->customer_earn = $model['price']*$multiplier;
            $earning->company_earn = $earning->customer_earn*$tier_charge;
            $earning->customer_earn_after = $earning->customer_earn - $earning->company_earn;
            $earning->staff_earn = $earning->company_earn/2;
          }
          //
        }elseif ($model['purchase_type']== 'Nickel') {
          $earning->customer_earn = 0;
          $earning->customer_earn_after = 0;
          $earning->company_earn  = 0;
          $earning->staff_earn  = 0;
        }else{//purchase type is stocks
          $earning->customer_earn = 0;
          $earning->customer_earn_after = 0;
          $earning->company_earn  = 0;
          $earning->staff_earn  = 0;
        }
      }


      if ($model['purchase_type'] == 'Nickel' || $model['purchase_type'] == 'Stocks') {
        unset($earning);
      }else{
        $earning->save(false);
      }

    }


}
