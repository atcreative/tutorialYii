<?php

use yii\db\Migration;

class m170502_084412_chagne_detail_to_text_from_book_table extends Migration
{
    public function up()
    {
		$this->alterColumn('book', 'detail', $this->text());
    }

    public function down()
    {
			$this->alterColumn('book', 'detail', $this->integer());
    }

}
