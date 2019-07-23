<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Cache\BackendInterface;
use Phalcon\Logger\AdapterInterface;

/**
 * Class ApiController
 * @package App\Controllers
 */
class ApiController extends Controller
{

	protected function checkIfCached()
	{
		/** @var BackendInterface $cache */
		$cache = $this->getDI()->get('cache');
		$url   = $this->request->getURI();

		if ($cache->exists($url)) {
			$this->send($cache->get($url));
		}
	}

	/**
	 * @param $data
	 */
	protected function storeInCache($data)
	{
		/** @var BackendInterface $cache */
		$cache = $this->getDI()->get('cache');
		$url   = $this->request->getURI();

		$cache->save($url, $data);
	}

	/**
	 * Purges only API calls
	 */
	protected function flushCache()
	{
		/** @var BackendInterface $cache */
		$cache = $this->getDI()->get('cache');

		foreach ($cache->queryKeys('cache/api') as $key) {
			$cache->delete($key);
		}
	}

	/**
	 * Sets JSON content and sends a response
	 *
	 * @param $data
	 */
	protected function send($data)
	{
		$this->response->setJsonContent($data);
		$this->response->send();
		exit;
	}

	/**
	 * @param array $messages
	 */
	protected function log(array $messages)
	{
		$url = $this->request->getURI();

		/** @var AdapterInterface $logger */
		$logger = $this->getDI()->get('logger');
		$logger->alert("An error occured while calling url: $url, with next messages");

		foreach ($messages as $message) {
			$logger->error($message);
		}
	}
}
