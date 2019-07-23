<?php

use Phalcon\Db\Index;
use Phalcon\Db\Column;
use Phalcon\Db\Adapter\Pdo;
use Yarak\Migrations\Migration;

class CreateItemsTable implements Migration
{
	/**
	 * Run the migration.
	 *
	 * @param Pdo $connection
	 */
	public function up(Pdo $connection)
	{
		$connection->createTable('items', null, [
			'columns' => [
				new Column('id',          ['type' => Column::TYPE_INTEGER, 'unsigned' => true, 'notNull' => true, 'autoIncrement' => true]),
				new Column('first_name',  ['type' => Column::TYPE_VARCHAR, 'size' => 30, 'notNull' => true]),
				new Column('last_name',   ['type' => Column::TYPE_VARCHAR, 'size' => 40]),
				new Column('phone',       ['type' => Column::TYPE_VARCHAR, 'size' => 17, 'notNull' => true]),
				new Column('country',     ['type' => Column::TYPE_VARCHAR, 'size' => 2]),
				new Column('timezone',    ['type' => Column::TYPE_VARCHAR, 'size' => 40]),
				new Column('inserted_on', ['type' => Column::TYPE_DATETIME, 'notNull' => true, 'default' => 'CURRENT_TIMESTAMP']),
				new Column('updated_on',  ['type' => Column::TYPE_DATETIME, 'notNull' => true, 'default' => 'CURRENT_TIMESTAMP']),
			],
			'indexes' => [
				new Index('items_pkey', ['id'], 'PRIMARY'),
				new Index('items_name_unique', ['first_name', 'last_name'], 'UNIQUE'),
				new Index('items_phone_unique', ['phone'], 'UNIQUE'),
				new Index('items_full_text', ['first_name', 'last_name'], 'FULLTEXT'),
			]
		]);
	}

	/**
	 * Reverse the migration.
	 *
	 * @param Pdo $connection
	 */
	public function down(Pdo $connection)
	{
		$connection->dropTable('items');
	}
}
