<?php

use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;

error_reporting(E_WARNING);


define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH. '/app');

try {
	/**
	 * The FactoryDefault Dependency Injector automatically registers
	 * the services that provide a full stack framework.
	 */
	$di = new FactoryDefault();

	/**
	 * Initialize micro application
	 */
	$app = new Micro($di);

	/**
	 * Read services
	 */
	include APP_PATH. '/config/services.php';

	/**
	 * Include Autoloader
	 */
	include APP_PATH. '/config/loader.php';

	/**
	 * Handle routes
	 */
	include APP_PATH. '/config/router.php';


	/**
	 * Handle the request
	 */
	if (php_sapi_name() != "cli") {
		$app->handle();
	}
} catch (\Exception $e) {
	echo $e->getMessage(). '<br>';
	echo '<pre>'. $e->getTraceAsString(). '</pre>';
}
