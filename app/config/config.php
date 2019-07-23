<?php

use Phalcon\Config;
use Phalcon\Db\Dialect\MysqlExtended;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__). '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH. '/app');

return new Config([
	'database' => [
		'adapter'  => 'Mysql',
		'host'     => 'mysql',
		'username' => 'default',
		'password' => 'secret',
		'dbname'   => 'default',
		'dialectClass' => MysqlExtended::class
	],
	'redis' => [
		'host' => 'redis',
		'port' => 6379,
		'persistent' => false,
		'prefix' => 'cache',
        'statsKey' => '_PHCR',
	],
	'application'  => [
		'title'    => 'Phonebook',
		'baseUri'  => '/',

		'appDir'         => APP_PATH. '/',
		'consoleDir'     => APP_PATH. '/console/',
		'databaseDir'    => APP_PATH. '/database/',
		'migrationsDir'  => APP_PATH. '/database/migrations/',
		'validationDir'  => APP_PATH. '/validation/',
		'validatorsDir'  => APP_PATH. '/validation/validator/',
		'controllersDir' => APP_PATH. '/controllers/',
		'modelsDir'      => APP_PATH. '/models/',
	],
	'hostaway' => [
		'baseApiUrl' => 'https://api.hostaway.com/',
		'endpoints' => [
			'country'  => 'countries',
			'timezone' => 'timezones',
		],
	],
]);
