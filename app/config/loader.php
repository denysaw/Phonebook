<?php

use Phalcon\Loader;

$config = $di->get('config');

$loader = new Loader();

$loader->registerNamespaces([
	'App\Models' => $config->application->modelsDir,
	'App\Validation' => $config->application->validationDir,
	'App\Validation\Validator' => $config->application->validatorsDir,
	'App\Controllers' => $config->application->controllersDir,
]);

$loader->register();

/**
 * Use composer autoloader to load vendor classes
 */
require_once BASE_PATH. '/vendor/autoload.php';