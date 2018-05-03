<?php

namespace backend\controllers;

use Yii;
use common\models\Stocks;
use common\models\StocksSearch;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\User;
use common\models\ProductManagement;
use common\models\StocksLine;
use common\models\StocksLineSearch;
use common\models\StocksLinea;
use common\models\StocksLineaSearch;
use common\models\PurchaseSearch;
use common\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * StocksController implements the CRUD actions for Stocks model.
 */
class StocksController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
      foreach ( $userGroupArray as $uGId => $uGName ){
          $permission = UserPermission::find()->where(['controller' => 'Stocks'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Stocks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StocksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stocks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
          $model = $this->findModel($id);
//$modelLine = StocksLine::find()->where(['stocks_id'=>$id])->all();
        $searchLine = new StocksLineSearch();
        $searchLine->stocks_id = $id;
        $modelLine = $searchLine->search(Yii::$app->request->queryParams);

        $searchLinea = new StocksLineaSearch();
        $searchLinea->stocks_id = $id;
        $modelLinea = $searchLinea->search(Yii::$app->request->queryParams);

        $purchase = new PurchaseSearch();
        $purchase->product =$model->product_id;
        $purchase->purchase_type = 'Stocks';
        $purchaseData = $purchase->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'modelLine'=>$modelLine,
            'modelLinea'=>$modelLinea,
            'purchaseData'=>$purchaseData,
        ]);
    }

    /**
     * Creates a new Stocks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stocks();
        $modelLine = [new StocksLine];
        $modelLinea = [new StocksLinea];
        if ($model->load(Yii::$app->request->post()) ) {

            $modelLine = Model::createMultiple(StocksLine::classname());
            Model::loadMultiple($modelLine, Yii::$app->request->post());
            $modelLinea = Model::createMultiple(StocksLinea::classname());
            Model::loadMultiple($modelLinea, Yii::$app->request->post());

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelLine)&&  Model::validateMultiple($modelLinea) && $valid;
        //    echo '<pre>';
          //    var_dump($valid);die();
            if ($valid) {
                $prods = new ProductManagement();
                $product_id =  $prods->addProduct($model->stock,1);
                $model->product_id = $product_id;
              //  var_dump($product_id);die();
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    if ($flag = $model->save(false)) {
                        foreach ($modelLine as $line)
                        {
                            $line->stocks_id = $model->id;
                            if (! ($flag = $line->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelLinea as $linea)
                        {
                            $linea->stocks_id = $model->id;
                            if (! ($flag = $linea->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Stock created");
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

            //$model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelLine'=> (empty($modelLine)) ? [new StocksLine] : $modelLine,
                'modelLinea'=> (empty($modelLinea)) ? [new StocksLinea] : $modelLinea,
            ]);
        }
    }

    /**
     * Updates an existing Stocks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelLine = StocksLine::find()->where(['stocks_id' => $id])->all();
        $modelLinea = StocksLinea::find()->where(['stocks_id' => $id])->all();
        $model->date = date('d M Y', strtotime($model->date) );
        if ($model->load(Yii::$app->request->post())  ) {

            $oldIDs = ArrayHelper::map($modelLine, 'id', 'id');
            $stockline = Model::createMultiple(StocksLine::classname(), $modelLine);
            Model::loadMultiple($stockline, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($stockline, 'id', 'id')));

            $oldIDsa = ArrayHelper::map($modelLinea, 'id', 'id');
            $stocklinea = Model::createMultiple(StocksLinea::classname(), $modelLinea);
            Model::loadMultiple($stocklinea, Yii::$app->request->post());
            $deletedIDsa = array_diff($oldIDsa, array_filter(ArrayHelper::map($stocklinea, 'id', 'id')));


            $valid = $model->validate();
          //  $valid = Model::validateMultiple($modelLine)&&  Model::validateMultiple($modelLinea) && $valid;
            $valid = Model::validateMultiple($stockline)&&  Model::validateMultiple($stocklinea) && $valid;

          //  $valid = Model::validateMultiple($stockline) && $valid;

            //var_dump($valid);die();
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                  try {

                        if ($flag = $model->save(false)) {
                            if (! empty($deletedIDs)) {
                              StocksLine::deleteAll(['id' => $deletedIDs]);
                            }

                        foreach ($stockline as $line) {
                            $line->stocks_id = $model->id;
                            if (! ($flag = $line->save(false))) {
                                $transaction->rollBack();
                                break;
                              }
                            }

                        if (! empty($deletedIDsa)) {
                          StocksLinea::deleteAll(['id' => $deletedIDsa]);
                         }

                         foreach ($stocklinea as $linea) {
                             $linea->stocks_id = $model->id;
                             if (! ($flag = $linea->save(false))) {
                                 $transaction->rollBack();
                                 break;
                               }
                             }

                        }
                        if ($flag) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', "Stock updated");
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

            //$model->save(false);
          //  return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelLine'=> (empty($modelLine)) ? [new StocksLine] : $modelLine,
                'modelLinea'=> (empty($modelLinea)) ? [new StocksLinea] : $modelLinea,
            ]);
        }
    }

    public function actionAjaxLocal(){
      $prods = 0;
      if ( Yii::$app->request->post() ) {
        $price = Yii::$app->request->post()['price'];
        $rate = Yii::$app->request->post()['rate'];
      //  $this->total_cost_price = str_replace(",", "", $this->total_cost_price)
        $price = str_replace(",", "", $price);
        $rate = str_replace(",", "", $rate);
        $prods = $rate * $price;
        return $prods;
      }

    }

    /**
     * Deletes an existing Stocks model.
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
     * Finds the Stocks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stocks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stocks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
