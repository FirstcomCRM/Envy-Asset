<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "announcement".
 *
 * @property integer $id
 * @property string $title
 * @property string $announcement
 * @property string $date_created
 * @property string $date_modified
 * @property string $created_by
 * @property string $modified_by
 */
class Announcement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'announcement';
    }

    public function behaviors()
     {
      return [
        'sammaye\audittrail\LoggableBehavior'
      ];
     }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'announcement'], 'required'],
            [['announcement'], 'string'],
            [['date_created', 'date_modified'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['created_by', 'modified_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'announcement' => 'Announcement',
            'date_created' => 'Date Created',
            'date_modified' => 'Date Modified',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
        ];
    }
}
