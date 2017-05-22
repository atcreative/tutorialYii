<?php

use yii\db\Migration;

/**
 * Handles the creation of table `permissions`.
 */
class m170522_023049_create_permissions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('permissions', [
            'id' => $this->primaryKey(),
            'role_name' => $this->string(100),
            'permissions_role_id' => $this->integer(),
            'permissions_resource_id' => $this->integer(),
            'tenant_id' => $this->integer(),
            'store_id' => $this->integer(),
            'status' => $this->integer(),
            'dt_created' => $this->integer(),
            'dt_modified' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('permissions');
    }
}
