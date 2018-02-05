<?php

namespace backend\controllers;

use Yii;
use common\models\ImportMetal;
use common\models\ImportMetalSearch;
use common\models\UserPermission;
use common\models\User;
use common\models\UserGroup;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * ImportMetalController implements the CRUD actions for ImportMetal model.
 */
class ImportMetalController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'ImportMetal'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all ImportMetal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImportMetalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ImportMetal model.
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
     * Creates a new ImportMetal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * Imports excel file and create a save record on the table for future reference
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ImportMetal();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->date_file = date('Y-m-d', strtotime($model->date_file) );
            $model->date_added = date('Y-m-d h:i:s');
            $model->file = UploadedFile::getInstance($model,'file');
            if (!empty($model->file)) {
              $model->validate();
              $filename= $model->upload();
              $model->save(false);
              $model->importExcel($filename);
            }
            Yii::$app->session->setFlash('success',"File sucessfully uploaded");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ImportMetal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
    *A test function that performs the input without uploading the file
    */
     public function actionImport(){
       $filename = '1502272349May 2017.xlsx';
       $model = new ImportMetal();
       $model->importExcel($filename);
     }


     /*
     Download file tmeplate for metal price
     */
     public function actionDownload(){
         $filename = 'import_metal_sample.xlsx';
         $path = Yii::getAlias('@webroot');
         $path1 = Yii::getAlias('@template');
         $new_path = $path.'/'.$path1.'/'.$filename;
         Yii::$app->response->sendFile($new_path);
     }

     public function actionBaseMetal(){
       $model = new ImportMetal();

       if ($model->load(Yii::$app->request->post()) ) {
           $model->date_file = date('Y-m-d', strtotime($model->date_file) );
           $model->date_added = date('Y-m-d h:i:s');
           $model->file = UploadedFile::getInstance($model,'file');
           if (!empty($model->file)) {
             $model->validate();
             $filename= $model->upload();
             $model->save(false);
             $model->importBase($filename);
           }
           Yii::$app->session->setFlash('success',"File sucessfully uploaded");
           return $this->redirect(['view', 'id' => $model->id]);
       } else {
           return $this->render('create-base', [
               'model' => $model,
           ]);
       }
     }

     public function actionNickelDeal(){
       $model = new ImportMetal();

       if ($model->load(Yii::$app->request->post()) ) {
           $model->date_file = date('Y-m-d', strtotime($model->date_file) );
           $model->date_added = date('Y-m-d h:i:s');
           $model->file = UploadedFile::getInstance($model,'file');
           if (!empty($model->file)) {
             $model->validate();
             $filename= $model->upload();
             $model->save(false);
             $model->importNickel($filename);
           }
           Yii::$app->session->setFlash('success',"File sucessfully uploaded");
           return $this->redirect(['view', 'id' => $model->id]);
       } else {
           return $this->render('create-nickel', [
               'model' => $model,
           ]);
       }
     }

     /**
      * Deletes an existing ImportMetal model.
      * If deletion is successful, the browser will be redirected to the 'index' page.
      * @param integer $id
      * @return mixed
      */


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTruncate(){
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
      Yii::$app->session->setFlash('success',"Truncate Successful");
      return $this->redirect(['index']);
    }

    /**
     * Finds the ImportMetal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImportMetal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImportMetal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
