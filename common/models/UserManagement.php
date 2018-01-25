<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\UserGroup;
use common\models\Department;
/**
 * This is the model class for table "user_management".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $user_group
 * @property string $department
 * @property string $email
 * @property string $nationality
 * @property string $address
 * @property integer $mobile
 * @property string $remark
 * @property string $login_id
 * @property string $login_password
 */
class UserManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public function behaviors()
 	   {
   		return [
   			'sammaye\audittrail\LoggableBehavior'
   		];
 	   }

    public static function tableName()
    {
        return 'user_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_group', 'department', 'email', 'login_id', 'login_password'], 'required'],
            [['user_id', 'mobile', 'apply_tier','tier_level'], 'integer'],
            [['remark','address'], 'string'],
            [['name'],'unique'],
            [['connect_to'],'string','max'=>3],
            [['name', 'email'], 'string', 'max' => 75],
            [['user_group', 'department', 'nationality'], 'string', 'max' => 50],
            [['login_password'], 'string', 'max' => 100],
          //  [['login_id'], 'string', 'max' => 25],
            [['login_id'], 'unique'],
            [['email'], 'unique'],
            [['email'],'email'],
            [['date_adedd'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'user_group' => 'User Group',
            'department' => 'Department',
            'email' => 'Email',
            'nationality' => 'Nationality',
            'apply_tier'=>'Apply Tier',
            'tier_level'=>'Tier Level',
            'connect_to' => 'Connect To',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'remark' => 'Remark',
            'login_id' => 'User Name',
            'login_password' => 'Password',
        ];
    }
    public function createUser(){

      if (!$this->validate() ) {
        return false;
      }else {
        $name = UserGroup::find()->where(['id'=>$this->user_group])->one();
        $user = new User();
        $user->username = $this->login_id;
        $user->email = $this->email;
      //  $user->user_group_id = $this->user_group;
        $user->user_group_id = $name->usergroup;
        $user->setPassword($this->login_password);
        $this->login_password = $user->password_hash;
        $this->user_id = $user->id;
        $user->generateAuthKey();
        $user->save();
        $this->user_id = $user->id;


        $auth = \Yii::$app->authManager;
    //    $role = $auth->getRole($this->user_group);
        $role = $auth->getRole($name->usergroup);
        $auth->assign($role, $user->id);
        return true;
      }
    }

    public function updateUser(){
      if (!$this->validate() ) {

        return false;
      }else {
        //$user = User::findOne(['username'=>$this->login_id]);
        $user = User::findOne(['id'=>$this->user_id]);
        $name = UserGroup::find()->where(['id'=>$this->user_group])->one();

        $oldrole = $user->user_group_id;
        $user->username = $this->login_id;
        $user->email = $this->email;
        $user->user_group_id = $name->usergroup;
        $user->setPassword($this->login_password);
        $this->login_password = $user->password_hash;
        $this->user_id = $user->id;
        $user->generateAuthKey();
        $user->save();
        $this->user_id = $user->id;

        $auth = \Yii::$app->authManager;
        $toRevoke = $auth->getRole($oldrole);
        $auth->revoke($toRevoke, $user->id);
      //  $toAssign = $auth->getRole($this->user_group);
        $toAssign = $auth->getRole($name->usergroup);
        $auth->assign($toAssign,$user->id);
        if ($user->update() != false) {
          return $user->update() ? $user : null;
        }
        return true;
      }

    }

    public function getDept(){
      return $this->hasOne(Department::className(),['id' => 'department'] );
    }

    public function getGroup(){
      return $this->hasOne(UserGroup::className(),['id' => 'user_group'] );
    }


}
