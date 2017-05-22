<?php

use yii\db\Migration;

/**
 * Handles the creation of table `permission_resource`.
 */
class m170522_033923_create_permission_resource_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('permission_resource', [
            'id' => $this->primaryKey(),
            'resource_name' => $this->string(100),
            'status' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('permission_resource');
    }
}
