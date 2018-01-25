<?php

namespace backend\controllers;

use Yii;
use common\models\Investor;
use common\models\InvestorSearch;
use common\models\UserPermission;
use common\models\User;
use common\models\UserGroup;
use common\models\DepositSearch;
use common\models\WithdrawSearch;
use common\models\PurchaseSearch;
//use common\models\DepositLine;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\db\Command;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class InvestorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'Investor'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvestorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * Added three search-type class that shows investor record based on their ids
     * @return mixed
     */
    public function actionView($id)
    {

        $search_dep = new DepositSearch();
        $search_dep->investor = $id;
        $deposit = $search_dep->search(Yii::$app->request->queryParams);

        $search_with = new WithdrawSearch();
        $search_with->investor = $id;
        $withdraw = $search_with->search(Yii::$app->request->queryParams);

        $search_pur = new PurchaseSearch();
        $search_pur->investor = $id;
        $purchase = $search_pur->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'deposit'=>$deposit,
            'withdraw'=>$withdraw,
            'purchase'=>$purchase,
        ]);
    }



    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * Has a investor account login, where creating an investor automatically creates an account to login
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Investor();

        if ($model->load(Yii::$app->request->post()) ) {

          $data = User::find()->where(['username'=>$model->username])->one();
          $data_e = User::find()->where(['email'=>$model->email])->one();

          if (empty($data->username) && empty($data_e->email)) {

            if ($model->createUser()) {
              Yii::$app->session->setFlash('success', "Investor has been added");
              return $this->redirect(['view', 'id' => $model->id]);
            }else{
          //      print_r($model->getErrors() );die();
              //  var_dump($model->errors);
              Yii::$app->session->setFlash('error', "Failed to create Investor");
              return $this->render('create', [
                  'model' => $model,
              ]);
            }
          }else{
            Yii::$app->session->setFlash('error', "UserName/Email has already been taken");
            return $this->render('create', [
                'model' => $model,
            ]);
          }


        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * Update the user account that is used to login as well
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            if ($model->updateUser() ) {
              Yii::$app->session->setFlash('success', "Investor has been updated");
              return $this->redirect(['view', 'id' => $model->id]);
            }else{
                  //var_dump($model->errors);die();
              Yii::$app->session->setFlash('error', "Failed to update Investor");
              return $this->render('update', [
                  'model' => $model,
              ]);
            }

            Yii::$app->session->setFlash('error', "UserName/Email has already been taken");
            return $this->render('create', [
                'model' => $model,
            ]);


        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $del = User::find()->where(['customer_id'=>$id])->one();
        if (!empty($del)) {
          $del->delete();
        }
        //  Yii::$app->db->createCommand()->delete('grand_line', ['Header_ID' => $id])->execute();
        Yii::$app->session->setFlash('success', "Invesstor has been deleted");
        return $this->redirect(['index']);
    }

    public function actionImport(){
      $model = new Investor();

      if ($model->load(Yii::$app->request->post()  ) ) {
        $model->file = UploadedFile::getInstance($model,'file');
        if (!empty($model->file) ) {
            $filename= $model->upload();
            $model->importExcel($filename);
            $searchModel = new InvestorSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            Yii::$app->session->setFlash('success', "Import Successful");
            //  return $this->redirect(['index', 'searchModel' => $searchModel,  'dataProvider' => $dataProvider]);
              return $this->redirect(['index']);
        /*    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);*/
        }

      } else {
          return $this->render('_import', [
              'model' => $model,
          ]);
      }

    }

    public function actionDownload(){
        $filename = 'import_customer_sample.xlsx';
        $path = Yii::getAlias('@webroot');
        $path1 = Yii::getAlias('@template');
        $new_path = $path.'/'.$path1.'/'.$filename;
        Yii::$app->response->sendFile($new_path);
    }


    /**
    *A custom-view for investors. When investors login, this will show their resepctive records, such as
    *Also prevents investors to access other applications that is only meant for the staff/employees
    */
    public function actionCView($id){
      $search_dep = new DepositSearch();
      $search_dep->investor = $id;
      $deposit = $search_dep->search(Yii::$app->request->queryParams);

      $search_with = new WithdrawSearch();
      $search_with->investor = $id;
      $withdraw = $search_with->search(Yii::$app->request->queryParams);

      $search_pur = new PurchaseSearch();
      $search_pur->investor = $id;
      $purchase = $search_pur->search(Yii::$app->request->queryParams);

      $this->layout = 'c-main';

      return $this->render('c-view', [
          'model' => $this->findModel($id),
          'deposit'=>$deposit,
          'withdraw'=>$withdraw,
          'purchase'=>$purchase,
      ]);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Investor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
