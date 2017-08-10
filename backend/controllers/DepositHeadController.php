<?php

namespace backend\controllers;

use Yii;
use common\models\DepositHead;
use common\models\DepositHeadSearch;
use common\models\DepositLineSearch;
use common\models\User;
use common\models\UserGroup;
use common\models\UserPermission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * DepositHeadController implements the CRUD actions for DepositHead model.
 */
class DepositHeadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
      foreach ( $userGroupArray as $uGId => $uGName ){
          $permission = UserPermission::find()->where(['controller' => 'DepositHead'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all DepositHead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepositHeadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DepositHead model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new DepositLineSearch();
        $searchModel->header_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'dataProvider'=> $dataProvider,
        ]);
    }

    /**
     * Creates a new DepositHead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DepositHead();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DepositHead model.
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
     * Deletes an existing DepositHead model.
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
     * Finds the DepositHead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DepositHead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DepositHead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
