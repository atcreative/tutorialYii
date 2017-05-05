<?php

use yii\db\Migration;

/**
 * Handles dropping visible from table `book`.
 */
class m170502_081147_drop_visible_column_from_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('book', 'visible');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('book', 'visible', $this->integer());
    }
}
