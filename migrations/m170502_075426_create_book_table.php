<?php

use yii\db\Migration;

/**
 * Handles the creation of table `book`.
 */
class m170502_075426_create_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'detail' => $this->text(),
            'price' => $this->float(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('book');
    }
}
