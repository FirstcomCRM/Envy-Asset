<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\UserGroup;
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
     public $file;
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
            [['company_name', 'customer_group', 'nric', 'contact_person', 'email', 'mobile','bank_a', 'username','password','usergroup'], 'required'],
            [['company_name','nric'],'unique'],
            [['salesperson'], 'integer'],
            [['address', 'remark','email_cc','bank_b','bank_c','bank_d','bank_e'], 'string'],
            [['company_name', 'customer_group', 'contact_person'], 'string', 'max' => 75],
            [['email'], 'string', 'max' => 50],
            [['email'],'email'],
            [['mobile','company_registration'],'string','max'=>25],
            [['nric_comp'],'string','max'=>50],
            [['date_added','start_date'],'safe'],
            [['file'],'file','skipOnEmpty'=>true, 'mimeTypes'=>'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
               'wrongMimeType'=>'Invalid file format. Please use .xls or .xlsx',
            ],
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
            'nric'=>'NRIC',
            'nric_comp'=>'NRIC Customer',
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
            'bank_a'=>'Bank Account 1',
            'bank_b'=>'Bank Account 2',
            'bank_c'=>'Bank Account 3',
            'bank_d'=>'Bank Account 4',
            'bank_e'=>'Bank Account 5',
            'start_date'=>'Start Date',
            'passport_no'=>'Passport/FIN No',
            'company_registration'=>'Company Registration',
            'email_cc'=>'Email CC',
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
        $group = UserGroup::findOne($this->usergroup);
      //  print_r($group->usergroup);die();
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->user_group_id = $group->usergroup;
      //  $user->user_group_id = $this->usergroup;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $this->password = $user->password_hash;
        $this->nric_comp = $this->nric.' '.$this->company_name;
        $this->start_date = date('Y-m-d',strtotime($this->start_date) );
        $this->date_added = date('Y-m-d h:i:s');
        //$user->user_id = 0;
      //  $user->save();
        $this->save(false);
        $user->customer_id = $this->id;
        $user->save();

        $auth = \Yii::$app->authManager;
        $role = $auth->getRole($group->usergroup);
        $auth->assign($role, $user->id);
        return true;
      }
    }

    public function updateUser(){
      if (!$this->validate() ) {
        return false;
      }else{
    //    echo $this->usergroup;die();
        $user = User::find()->where(['customer_id'=>$this->id])->one();
        if (is_null($user) ) {
          return $this->createUser();
        }else{
          $group = UserGroup::findOne($this->usergroup);
        //  echo $group->usergroup;die();
          $oldrole =  $group->usergroup;
          $user->username = $this->username;
          $user->email = $this->email;
          $user->user_group_id = $group->usergroup;
          $user->setPassword($this->password);
          $user->generateAuthKey();
          $this->password = $user->password_hash;
          $this->nric_comp = $this->nric.' '.$this->company_name;
          $this->start_date = date('Y-m-d',strtotime($this->start_date) );
          $this->save(false);
          $user->customer_id = $this->id;
          $user->save();

          $auth = \Yii::$app->authManager;
          $toRevoke = $auth->getRole($oldrole);
          $auth->revoke($toRevoke, $user->id);
          $toAssign = $auth->getRole($group->usergroup);
          $auth->assign($toAssign,$user->id);
          if ($user->update() != false) {
            return $user->update() ? $user : null;
          }
          return true;
        }

      }

    }

    public function upload(){
      $filename = $this->file->name;
      $this->file->saveAs(Yii::getAlias('@investor').'/'.$filename);
      return $filename;
    }


    public function importExcel($filename){
      $inputFile = Yii::getAlias('@investor').'/'.$filename;
      try {
        $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFile);
      } catch (Exception $e) {
        die('Error');
      }


      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();

      for ($row=2; $row<=$highestRow ; $row++) {
        $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        $invest = new Investor();
        $invest->company_name = $rowData[0][0];
        $invest->nric = $rowData[0][2];
        $invest->bank_a = $rowData[0][3];
        $invest->email = $rowData[0][4];
        $invest->mobile = $rowData[0][5];
        $invest->nric_comp = $invest->nric.' '.$invest->company_name;
        $invest->date_added = date('Y-m-d h:i:s');
        $test_date = '2018-01-01';
        $invest->start_date = date('Y-m-d',strtotime($test_date));
        $invest->date_added = date('Y-m-d h:i:s');
        $invest->save(false);
    //    print_r($invest->company_name);die();

      }


    }


}
