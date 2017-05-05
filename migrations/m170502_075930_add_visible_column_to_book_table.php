<?php

use yii\db\Migration;

/**
 * Handles adding visible to table `book`.
 */
class m170502_075930_add_visible_column_to_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('book', 'visible', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('book', 'visible');
    }
}
