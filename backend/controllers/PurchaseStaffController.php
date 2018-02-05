<?php

namespace backend\controllers;

use Yii;
use common\models\PurchaseStaff;
use common\models\PurchaseStaffSearch;
use common\models\UserPermission;
use common\models\User;
use common\models\UserGroup;
use common\models\UserManagement;
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

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->date = date('Y-m-d', strtotime($model->date) );
            $model->date_added = date('Y-m-d h:i:s');
            $model->save(false);
            $model->purchase_no = date('Ym').'-'.sprintf("%005d", $model->id);
            $model->save(false);
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

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->date = date('Y-m-d', strtotime($model->date) );
            $model->save(false);
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
}
