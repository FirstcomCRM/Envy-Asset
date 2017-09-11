<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\models\LoginForm;
use common\models\Announcement;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     * Displays the annoucements created in the AnnoucmentController by 5,
     * Also if the login id is an investor, use the custom view meant for investor. Else, use the staff/employee view.
     * @return string
     */
    public function actionIndex()
    {

        $query = Announcement::find();
        $pagination = new Pagination([
           'defaultPageSize' => 5,
           'totalCount' => $query->count(),
         ]);

        $announce = $query->orderBy(['id'=>SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

      //      echo Yii::$app->user->id;die();
        $investor = User::find()->where(['id'=>Yii::$app->user->id])->one();
      //  print_r($investor);die();
        if ($investor->customer_id != 0) {
          $this->layout = 'c-main.php';
        }

        return $this->render('index',[
           'investor'=>$investor,
           'pagination' => $pagination,
           'announce'=> $announce,
        ]);


  //      return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout= '/printpreview';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
