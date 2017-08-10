<?php

namespace backend\controllers;

use Yii;
use common\models\WithdrawLine;
use common\models\WithdrawLineSearch;
use common\models\DepositHead;
use common\models\WithdrawHead;
use common\models\DepositLineSearch;
use common\models\User;
use common\models\UserGroup;
use common\models\UserPermission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
/**
 * WithdrawLineController implements the CRUD actions for WithdrawLine model.
 */
class WithdrawLineController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
      foreach ( $userGroupArray as $uGId => $uGName ){
          $permission = UserPermission::find()->where(['controller' => 'WithdrawLine'])->andWhere(['user_group_id' => $uGId ] )->all();
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

      return [
          'access' => [
              'class' => AccessControl::className(),
              // 'only' => ['index', 'create', 'update', 'view', 'delete'],
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

    }

    /**
     * Lists all WithdrawLine models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawLineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WithdrawLine model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model  =  $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new WithdrawLine model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new WithdrawLine();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->header_id = $id;
            $model->date_added = date('Y-m-d');
            $model->action = 'Withdraw';
            $model->save();
            Yii::$app->session->setFlash('success', "Withdraw successfully added!");
            return $this->redirect(['withdraw/view', 'id' => $id]);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WithdrawLine model.
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
     * Deletes an existing WithdrawLine model.
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
     * Finds the WithdrawLine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WithdrawLine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WithdrawLine::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
