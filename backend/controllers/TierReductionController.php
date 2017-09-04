<?php

namespace backend\controllers;

use Yii;
use common\models\TierReduction;
use common\models\TierReductionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
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
