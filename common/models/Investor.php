<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
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
      /* return [
         'sammaye\audittrail\LoggableBehavior'
       ];*/
       return [
           [
               'class' => BlameableBehavior::className(),
               'createdByAttribute' => 'created_by',
               'updatedByAttribute' => 'edited_by',
           ],
           [
             'class' => TimestampBehavior::className(),
             'createdAtAttribute' => 'date_created',
             'updatedAtAttribute' => 'date_edited',
           //  'value' => new Expression('NOW()'),
               'value' => date('Y-m-d H:i:s'),
           ],
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
            [['salesperson','edited_by','created_by'], 'integer'],
            [['address', 'remark','email_cc','bank_b','bank_c','bank_d','bank_e'], 'string'],
            [['company_name', 'customer_group', 'contact_person'], 'string', 'max' => 75],
            [['email'], 'string', 'max' => 50],
            [['email'],'email'],
            [['mobile','company_registration'],'string','max'=>25],
            [['nric_comp'],'string','max'=>50],
            [['date_added','start_date','date_created','date_edited'],'safe'],
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
      $highestColumn = 'O';

      $test = [];
      for ($row=2; $row<=$highestRow ; $row++) {
        $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

        if (!empty($rowData[0][1]) ) {
          $nric = Investor::find()->where(['nric'=>$rowData[0][1]])->one();
          if (!is_null($nric) ) {
            $model = $nric;
            $this->importUpdate($model, $rowData);
          }else{
            $model = new Investor();
            $this->importUpdate($model, $rowData);
          }
        }elseif(!empty($rowData[0][5]) ){
          $passport = Investor::find()->where(['passport_no'=>$rowData[0][5]])->one();
          if (!is_null($passport) ) {
            $model = $passport;
            $this->importUpdate($model, $rowData);
          }else{
            $model = new Investor();
            $this->importUpdate($model, $rowData);
          }
        }else{
          $model = new Investor();
          $this->importUpdate($model, $rowData);
        }

      }
  //    echo '<pre>';
//      print_r($test);
//      die();

    }

    protected function importUpdate($model, $rowData){
      //$model = new Investor();
      $model->company_name = $rowData[0][0];
      $model->nric = $rowData[0][1];
      $model->contact_person = $rowData[0][2];
      $model->email = $rowData[0][3];
      $model->mobile = $rowData[0][4];
      $model->passport_no = $rowData[0][5];
      $model->company_registration = $rowData[0][6];
      //  $metal->entry_date_usd = date($format = "Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][2]));
      $model->start_date = date($format = "Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][7]));
      $model->email_cc = $rowData[0][8];
      $model->remark = $rowData[0][9];
      $model->bank_a = $rowData[0][10];
      $model->bank_b = $rowData[0][11];
      $model->bank_c = $rowData[0][12];
      $model->bank_d = $rowData[0][13];
      $model->bank_e = $rowData[0][14];

      if (!empty($model->nric)) {
        $model->nric_comp = $model->nric.' '.$model->company_name;
      }elseif (!empty($model->passport_no) ) {
        $model->nric_comp = $model->passport_no.' '.$model->company_name;
      }else{
        $model->nric_comp =  $model->company_name;
      }
    //  die($model->nric_comp);
      $model->save(false);

  //    unset($model);
    }


}
