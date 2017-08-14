<?php

namespace common\models;

use Yii;
use common\models\MetalAl;
use common\models\MetalCu;
use common\models\MetalNi;
use common\models\MetalZn;
/**
 * This is the model class for table "import_metal".
 *
 * @property integer $id
 * @property string $date_file
 * @property string $file_name
 */
class ImportMetal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $file;
    public static function tableName()
    {
        return 'import_metal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_file'], 'required'],
            [['date_file'], 'safe'],
            [['file_name'], 'string', 'max' => 75],
            [['file'],'file','skipOnEmpty'=>false, 'mimeTypes'=>'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
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
            'date_file' => 'Date',
            'file_name' => 'File Name',
            'file'=>'Import File',
        ];
    }

    public function upload(){
      $filename =  time().$this->file;
      $this->file->saveAs(Yii::getAlias('@metal').'/'.$filename);
      $this->file_name = $this->file->baseName.'.'.$this->file->extension;
      return $filename;
    }

    public function importExcel($filename){
        $inputFile = Yii::getAlias('@metal').'/'.$filename;
      //  $inputFile = Yii::getAlias('@metal').'/'.'1502272349May 2017.xlsx';
      try {
        $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFile);
      } catch (Exception $e) {
        die('Error');
      }
      $sheet = $objPHPExcel->getSheet(3);
      $highestRow = $sheet->getHighestRow();

      $highestColumn = $sheet->getHighestColumn();

      for ($row=3; $row < $highestRow; $row++) {
         $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
         if ($rowData[0][0]=="Date" or $rowData[0][0]=="Aluminium") {
           continue;
         }

         $al = new MetalAl();
         $al->import_metal_id = $this->id;
         $al->date_uploaded = $this->date_file;
         $al->date = (string)$rowData[0][0];
         $al->al_cash =(string)$rowData[0][1];
         $al->al_three_month = (string)$rowData[0][2];
         $al->al_stocl = (string)$rowData[0][3];
         if (empty($rowData[0][0])) {
           break;
         }
         $al->save(false);

      }

      for ($row=26; $row < $highestRow; $row++) {
        $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Copper") {
          continue;
        }

        $cu = new MetalCu();
        $cu->import_metal_id = $this->id;
        $cu->date_uploaded = $this->date_file;
        $cu->date = (string)$rowData[0][0];
        $cu->cu_cash =(string)$rowData[0][1];
        $cu->cu_three_month = (string)$rowData[0][2];
        $cu->cu_stock = (string)$rowData[0][3];
        if (empty($rowData[0][0])) {
          break;
        }
        $cu->save(false);
      }

      for ($row=3; $row <$highestRow ; $row++) {
        $rowData = $sheet->rangeToArray('F'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Nickel") {
          continue;
        }

        $ni = new MetalNi();
        $ni->import_metal_id = $this->id;
        $ni->date_uploaded = $this->date_file;
        $ni->date = (string)$rowData[0][0];
        $ni->ni_cash =(string)$rowData[0][1];
        $ni->ni_three_month = (string)$rowData[0][2];
        $ni->ni_stock = (string)$rowData[0][3];
        if (empty($rowData[0][0])) {
          break;
        }
        $ni->save(false);

      }

      for ($row=26; $row <$highestRow ; $row++) {
        $rowData = $sheet->rangeToArray('F'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
        if ($rowData[0][0]=="Date" or $rowData[0][0]=="Zinc") {
          continue;
        }

        $zn = new MetalZn();
        $zn->import_metal_id = $this->id;
        $zn->date_uploaded = $this->date_file;
        $zn->date = (string)$rowData[0][0];
        $zn->zn_cash =(string)$rowData[0][1];
        $zn->zn_three_month = (string)$rowData[0][2];
        $zn->zn_stock = (string)$rowData[0][3];
        if (empty($rowData[0][0])) {
          break;
        }
        $zn->save(false);

      }

    }
}
