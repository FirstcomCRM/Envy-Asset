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
//use common\models\DepositLine;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
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
     * @return mixed
     */
    public function actionView($id)
    {
    /*    $link_deposit = DepositHead::find()->where(['customer_id'=>$id])->one();
        $search = new DepositLineSearch();
        $search->header_id = $link_deposit->id;
        $deposit = $search->search(Yii::$app->request->queryParams);

        $with = WithdrawHead::find()->where(['customer_id'=>$id])->one();
        $searchWithdraw = new WithdrawLineSearch();
        $searchWithdraw->header_id = $with->id;
        $dataWithdraw = $searchWithdraw->search(Yii::$app->request->queryParams);*/

      //  print_r($dataWithdraw->getModels());die();
        $search_dep = new DepositSearch();
        $search_dep->investor = $id;
        $deposit = $search_dep->search(Yii::$app->request->queryParams);

        $search_with = new WithdrawSearch();
        $search_with->investor = $id;
        $withdraw = $search_with->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'deposit'=>$deposit,
            'withdraw'=>$withdraw,
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Investor();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->date_added = date('Y-m-d h:i:s');
            $model->save();
          //  $model->addTransact();
            Yii::$app->session->setFlash('success', "Investor has been added");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Investor has been updated");
            return $this->redirect(['view', 'id' => $model->id]);
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
        Yii::$app->session->setFlash('success', "Invesstor has been deleted");
        return $this->redirect(['index']);
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
