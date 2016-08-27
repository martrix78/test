<?php

use yii\db\Migration;

class m160827_083556_create_table_code extends Migration
{
    public function up()
    {
		$this->execute('CREATE TABLE IF NOT EXISTS `code` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			`code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`id`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
    }

    public function down()
    {
		$this->execute('drop table code');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
