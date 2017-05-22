<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permissions".
 *
 * @property integer $id
 * @property string $role_name
 * @property integer $permissions_role_id
 * @property integer $permissions_resource_id
 * @property integer $tenant_id
 * @property integer $store_id
 * @property integer $status
 * @property integer $dt_created
 * @property integer $dt_modified
 */
class Permissions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permissions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permissions_role_id', 'permissions_resource_id', 'tenant_id', 'store_id', 'status', 'dt_created', 'dt_modified'], 'integer'],
            [['role_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role_name' => Yii::t('app', 'Role Name'),
            'permissions_role_id' => Yii::t('app', 'Permissions Role ID'),
            'permissions_resource_id' => Yii::t('app', 'Permissions Resource ID'),
            'tenant_id' => Yii::t('app', 'Tenant ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'status' => Yii::t('app', 'Status'),
            'dt_created' => Yii::t('app', 'Dt Created'),
            'dt_modified' => Yii::t('app', 'Dt Modified'),
        ];
    }
}
