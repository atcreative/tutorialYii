<?php

use yii\db\Migration;

class m170502_082147_add_comment_to_visible_column_from_book_table extends Migration
{
    public function up()
    {
		$this->addCommentOnCOlumn('book', 'visible', '0=hide,1-show');
    }

    public function down()
    {
		$this->dropCommentFromColumn('book', 'visible');

    }

    
}
