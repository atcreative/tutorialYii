<?php

use yii\db\Migration;

/**
 * Handles adding category_id to table `book`.
 */
class m170503_043613_add_category_id_column_to_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('book', 'category_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('book', 'category_id');
    }
}
