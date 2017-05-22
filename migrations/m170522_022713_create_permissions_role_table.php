<?php

use yii\db\Migration;

/**
 * Handles the creation of table `permissions_role`.
 */
class m170522_022713_create_permissions_role_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('permissions_role', [
            'id' => $this->primaryKey(),
            'role_name' => $this->string(100),
            'tenant_id' => $this->integer(),
            'store_id' => $this->integer(),
            'status' => $this->integer(),
            'permissions_role_id' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('permissions_role');
    }
}
