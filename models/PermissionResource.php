<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permission_resource".
 *
 * @property integer $id
 * @property string $resource_name
 * @property integer $status
 */
class PermissionResource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permission_resource';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['resource_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'resource_name' => Yii::t('app', 'Resource Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
