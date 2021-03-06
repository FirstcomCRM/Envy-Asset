<?php

namespace backend\controllers;

use Yii;
use common\models\UserManagement;
use common\models\UserManagementSearch;
use common\models\UserPermission;
use common\models\UserGroup;
use common\models\User;
use common\models\TierLevel;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserManagementController implements the CRUD actions for UserManagement model.
 */
class UserManagementController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
      foreach ( $userGroupArray as $uGId => $uGName ){
          $permission = UserPermission::find()->where(['controller' => 'UserManagement'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all UserManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserManagement model.
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
     * Creates a new UserManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserManagement();

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
              //die();
            if ($model->createUser()) {
                $model->date_added = date('Y-m-d h:i:s');
                $model->save(false);
                Yii::$app->session->setFlash('success', "User has been created");
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
              Yii::$app->session->setFlash('error', "Failed to create User");
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
     * Updates an existing UserManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            if ($model->updateUser() ) {
              $model->save(false);
              Yii::$app->session->setFlash('success', "User has been updated");
              return $this->redirect(['view', 'id' => $model->id]);
            }else{
              Yii::$app->session->setFlash('error', "Failed to update user");
              return $this->render('update', [
                  'model' => $model,
              ]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserManagement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $ids = $this->findModel($id);
        $this->findModel($id)->delete();
        $del = User::find()->where(['id'=>$ids->user_id])->one();
        if (!empty($del)) {
          $del->delete();
        }

        Yii::$app->session->setFlash('success', "User has been deleted");
        return $this->redirect(['index']);
    }

    public function actionFetchTier(){
      $out = [];
      if (isset($_POST['depdrop_parents'])) {
          $parents = $_POST['depdrop_parents'];
          if ($parents != null) {
              $cat_id = $parents[0];
              $data = TierLevel::find()->where(['id'=>$cat_id])->one();
              $list = UserManagement::find()->where(['tier_level'=>$data->connecting_level, 'apply_tier'=>1])->select(['id','name'])->asArray()->all();
              foreach ($list as $i => $part) {
                $out[] = ['id' => $part['id'], 'name' => $part['name']];
              }
                echo Json::encode(['output'=>$out, 'selected'=>'']);

              return;
          }
      }
      echo Json::encode(['output'=>'', 'selected'=>'']);
    }


    /*
    * Used for dependent dropdown when selecting the tier
    */
    public function actionLists($id){
      $data = TierLevel::find()->where(['id'=>$id])->one();
      $count = UserManagement::find()->where(['tier_level'=>$data->connecting_level, 'apply_tier'=>1])->count();
      $list = UserManagement::find()->where(['tier_level'=>$data->connecting_level, 'apply_tier'=>1])->all();

      if ($count>0) {
        foreach ($list as $i) {
          echo "<option value='".$i->id."'>".$i->name."</option>";
        }
      }else{
        echo "<option>N/A</option>";
      }



    //  print_r($list);
  //    die('test');
    }

    /**
     * Finds the UserManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
