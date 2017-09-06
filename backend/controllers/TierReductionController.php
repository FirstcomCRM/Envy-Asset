<?php

namespace backend\controllers;

use Yii;
use common\models\TierReduction;
use common\models\TierReductionSearch;
use common\models\User;
use common\models\UserGroup;
use common\models\UserPermission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * TierReductionController implements the CRUD actions for TierReduction model.
 */
class TierReductionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'TierReduction'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all TierReduction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TierReductionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TierReduction model.
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
     * Creates a new TierReduction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TierReduction();

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->highest_percent = $model->highest_percent/100;
            $model->lowest_percent = $model->lowest_percent/100;
            $model->reduction_percent = $model->reduction_percent/100;
            $model->date_added = date('Y-m-d h:i:s');
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TierReduction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->highest_percent = $model->highest_percent*100;
        $model->lowest_percent = $model->lowest_percent*100;
        $model->reduction_percent = $model->reduction_percent*100;

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $model->highest_percent = $model->highest_percent/100;
            $model->lowest_percent = $model->lowest_percent/100;
            $model->reduction_percent = $model->reduction_percent/100;
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TierReduction model.
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
     * Finds the TierReduction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TierReduction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TierReduction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
