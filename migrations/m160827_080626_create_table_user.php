<?php

use yii\db\Migration;

class m160827_080626_create_table_user extends Migration
{
    public function up()
    {
		$this->execute('CREATE TABLE IF NOT EXISTS `user` (
			`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
			`username` varchar( 100 ) NOT NULL ,
			`email` varchar( 100 ) NOT NULL ,
			PRIMARY KEY ( `id` )
			) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT =1'
		);
    }

    public function down()
    {
        $this->execute('drop table user;');
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
