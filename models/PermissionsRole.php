<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permissions_role".
 *
 * @property integer $id
 * @property string $role_name
 * @property integer $tenant_id
 * @property integer $store_id
 * @property integer $status
 * @property integer $permissions_role_id
 */
class PermissionsRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permissions_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tenant_id', 'store_id', 'status', 'permissions_role_id'], 'integer'],
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
            'tenant_id' => Yii::t('app', 'Tenant ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'status' => Yii::t('app', 'Status'),
            'permissions_role_id' => Yii::t('app', 'Permissions Role ID'),
        ];
    }
}
