<?php

namespace common\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $customer_group
 * @property string $contact_person
 * @property string $email
 * @property integer $mobile
 * @property string $address
 * @property string $remark
 */
class Investor extends \yii\db\ActiveRecord
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
        return 'investor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'customer_group', 'contact_person', 'email', 'mobile', 'address','username','password','usergroup'], 'required'],
            [['company_name'],'unique'],
            [['mobile','salesperson'], 'integer'],
            [['address', 'remark'], 'string'],
            [['company_name', 'customer_group', 'contact_person'], 'string', 'max' => 75],
            [['email'], 'string', 'max' => 50],
            [['email'],'email'],
            [['date_added'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Investor Name',
            'customer_group' => 'Group',
            'contact_person' => 'Contact Person',
            'salesperson'=>'Sales Person',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'remark' => 'Remark',
            'username'=> 'UserName',
            'password'=>'Password',
            'usergroup'=> 'User Group',
        ];
    }

    public function addTransact(){
          $deposit = new DepositHead();
          $deposit->customer_id = $this->id;
          $deposit->customer = $this->company_name;
          $deposit->date_created = date('Y-m-d');
          $deposit->save();

          $withdraw = new WithdrawHead();
          $withdraw->customer_id = $this->id;
          $withdraw->customer  = $this->company_name;
          $withdraw->date_created = date('Y-m-d');
          $withdraw->save();
    }

    public function createUser(){
      if (!$this->validate()) {
        return false;
      }else{
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->user_group_id = $this->usergroup;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $this->password = $user->password_hash;
        $this->date_added = date('Y-m-d h:i:s');
        //$user->user_id = 0;
      //  $user->save();
        $this->save(false);
        $user->customer_id = $this->id;
        $user->save();

        $auth = \Yii::$app->authManager;
        $role = $auth->getRole($this->usergroup);
        $auth->assign($role, $user->id);
        return true;
      }
    }

    public function updateUser(){
      if (!$this->validate() ) {
        return false;
      }else{
        $user = User::find()->where(['customer_id'=>$this->id])->one();
      //  die($this->id);
        $oldrole = $user->user_group_id;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->user_group_id = $this->usergroup;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $this->password = $user->password_hash;
        $this->save(false);
        $user->customer_id = $this->id;
        $user->save();

        $auth = \Yii::$app->authManager;
        $toRevoke = $auth->getRole($oldrole);
        $auth->revoke($toRevoke, $user->id);
        $toAssign = $auth->getRole($this->usergroup);
        $auth->assign($toAssign,$user->id);
        if ($user->update() != false) {
          return $user->update() ? $user : null;
        }
        return true;

      }

    }
}
