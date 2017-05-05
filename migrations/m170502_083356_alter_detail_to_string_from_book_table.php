<?php

use yii\db\Migration;

class m170502_083356_alter_detail_to_string_from_book_table extends Migration
{
    public function up()
    {
			$sql = 'alter table book MODIFY detail INTEGER';
			$this->execute($sql);
    }

    public function down()
    {
		$sql = 'alter table book MODIFY detail TEXT';
			$this->execute($sql);
    }

}
