<?php

namespace backend\controllers;

use Yii;
//use common\models\UserPermissionSearch;
use common\models\UserPermission;
use common\models\UserGroup;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



class UserPermissionController extends \yii\web\Controller
{

  public function behaviors()
  {
    $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'usergroup');
      foreach ( $userGroupArray as $uGId => $uGName ){
          $permission = UserPermission::find()->where(['controller' => 'UserPermission'])->andWhere(['user_group_id' => $uGId ] )->all();
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
              //    'only' => ['index', 'create', 'update', 'view', 'delete'],
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

  /*
  * One type function, get all the controller that managed the site and apply the user-permission via using c
  *checkboxes
  */
    public function actionPermissionSetting()
    {
      $controllerlist = [];
      if ($handle = opendir('../controllers')) {
          while (false !== ($file = readdir($handle))) {
              if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                  $controllerlist[] = $file;
              }
          }
          closedir($handle);
      }
      asort($controllerlist);

      foreach ($controllerlist as $controller):
          $handle = fopen('../controllers/' . $controller, "r");
          if ($handle) {
              while (($line = fgets($handle)) !== false) {
                  if (preg_match('/public function action(.*?)\(/', $line, $display)):
                      if (strlen($display[1]) > 2):
                          $addDash = preg_replace('/\B([A-Z])/', '-$1', $display[1]);
                          $controllerList[substr($controller, 0, -4)][] = strtolower($addDash);
                          // d($addDash);
                      endif;
                  endif;
              }
          }
          fclose($handle);
      endforeach;

      $controllerActions = false;
      $userGroupId = 0;
      $controllerNameChosen = '';
      $controllerNameLong = '';
      $userGroup = UserGroup::find()->all();
      $permission = [];


      if ( isset( $_GET['c'] ) && !empty( $_GET['c'] ) && isset( $_GET['u'] ) && !empty( $_GET['u'] ) ) {
          $controllerName = $_GET['c'];
          $userGroupId = $_GET['u'];

          $controllerNameLong = $controllerName.'Controller';
          $controllerNameChosen = $controllerNameLong;
          $controllerActions = $controllerList[$controllerNameLong];

          $getPermission = UserPermission::find()->where(['user_group_id' => $userGroupId])->andWhere(['controller' => $controllerName])->all();
          foreach ( $getPermission as $gP ) {
              $permission[] = $gP->action;
          }
      }

      if (Yii::$app->request->post()) {
          // d(Yii::$app->request->post());exit;
          $controllerNameLong = Yii::$app->request->post()['controllerName'];
          $getModelName = explode('Controller', $controllerNameLong);
          $controllerName = $getModelName[0];
          $userGroupId = Yii::$app->request->post()['userGroup'];

          $controllerNameChosen = $controllerNameLong;
          $controllerActions = $controllerList[$controllerNameLong];
          $permission = [];
          $getPermission = UserPermission::find()->where(['user_group_id' => $userGroupId])->andWhere(['controller' => $controllerName])->all();
          foreach ( $getPermission as $gP ) {
              $permission[] = $gP->action;
          }

          if ( isset( Yii::$app->request->post()['checkBox'] ) && !empty ( Yii::$app->request->post()['checkBox'] ) )  {
          // d(Yii::$app->request->post());exit;
              UserPermission::deleteAll("user_group_id = $userGroupId AND controller = '$controllerName' ");
              $checkBox = Yii::$app->request->post()['checkBox'] ;
              foreach ( $checkBox as $actions => $cB ) {
                  $newPermission = new UserPermission();
                  $newPermission->controller = $controllerName;
                  $newPermission->action = $actions;
                  $newPermission->user_group_id = $userGroupId;
                  $newPermission->save();
              }
             Yii::$app->session->setFlash('success', "User Permission added.");
              return $this->redirect(['permission-setting','c' => $controllerName, 'u' => $userGroupId]);
          }
      }

      //print_r($controllerNameLong);
      //die();
      return $this->render('permission-setting',[
        'userGroup' => $userGroup,
        'userGroupId' => $userGroupId,
        'controllerNameLong' => $controllerNameLong,
        'controllerNameChosen' => $controllerNameChosen,
        'controllerList' => $controllerList,
        'controllerActions' => $controllerActions,
        'permission' => $permission,
      ]);



    }

}
