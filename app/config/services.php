<?php

use Yarak\Kernel;
use GuzzleHttp\Client;
use Phalcon\Cache\Frontend\Json;
use Phalcon\Logger\Adapter\File;
use Phalcon\Cache\Backend\Redis as RedisCache;
use Phalcon\Mvc\Model\MetaData\Redis as RedisMetaData;
use Phalcon\Mvc\Model\MetaData\Strategy\Annotations as StrategyAnnotations;

/**
 * Shared configuration service
 */
$di->setShared('config', function() {
	return include APP_PATH. "/config/config.php";
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function() {
	$config = (array) $this->getConfig()->database;
	$class  = 'Phalcon\Db\Adapter\Pdo\\'. $config['adapter'];
	unset($config['adapter']);

	return new $class($config);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function() {
	$options = $this->getConfig()->redis;

	$metadata = new RedisMetaData([
		'host' => $options->host,
		'port' => $options->port,
		'persistent' => true,
		'lifetime' => 86400,
		'prefix' => 'meta',
	]);

	$metadata->setStrategy(new StrategyAnnotations());

	return $metadata;
});

$di->setShared('cache', function() {
	$options = (array) $this->getConfig()->redis;
	$frontCache = new Json([
		'lifetime' => 3600
	]);

	return new RedisCache($frontCache, $options);
});

$di->setShared('logger', function() {
	return new File(APP_PATH. '/../log/error.log');
});

$di->setShared('client', function() {
	return new Client();
});

$di->setShared('yarak', function() {
	return new Kernel();
});
