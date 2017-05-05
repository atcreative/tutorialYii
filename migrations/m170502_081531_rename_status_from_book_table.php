<?php

use yii\db\Migration;

class m170502_081531_rename_status_from_book_table extends Migration
{
    public function up()
    {
		$this->renameColumn('book', 'status', 'visible');
    }

    public function down()
    {
		$this->renameColumn('book','visible', 'status');
    }


}
