<?php

namespace common\models;

use Yii;

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
      try {
        $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFile);
      } catch (Exception $e) {
        die('Error');
      }

      echo '<pre>';
      print_r($objPHPExcel);
      echo '</pre>';
  //    print_r($this->file_name);die();
    }
}
