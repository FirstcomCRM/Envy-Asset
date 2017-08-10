<?php

namespace backend\controllers;

use Yii;
use common\models\Announcement;
use common\models\AnnouncementSearch;
use common\models\User;
use common\models\UserGroup;
use common\models\UserPermission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * AnnouncementController implements the CRUD actions for Announcement model.
 */
class AnnouncementController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'Announcement'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Announcement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnnouncementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = Announcement::find();
        $pagination = new Pagination([
           'defaultPageSize' => 3,
           'totalCount' => $query->count(),
       ]);

        $announce = $query->orderBy('title')
        ->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
             'pagination' => $pagination,
        //     'announce'=> $announce,
        ]);
    }

    /**
     * Displays a single Announcement model.
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
     * Creates a new Announcement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Announcement();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->date_created = date('Y-m-d h:i:sa');
            $model->created_by = Yii::$app->user->identity->username;
            $model->save();
        //      return $this->red;irect(['site/index']);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Announcement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())  ) {
            $model->date_modified = date('Y-m-d H:i:s');
            $model->modified_by = Yii::$app->user->identity->username;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Announcement model.
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
     * Finds the Announcement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Announcement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Announcement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
