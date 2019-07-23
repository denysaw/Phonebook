<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

namespace App\Validation\Validator;

use GuzzleHttp\Client;
use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;
use Phalcon\Cache\BackendInterface;

/**
 * Validates that a value is one of the Hostaway allows
 */
class Hostaway extends Validator
{

	const MESSAGE_NO_ENDPOINTS = "There's no Hostaway endpoints related to '%s' field";
	const MESSAGE_FETCH_ERROR  = "An error has occured while fetching '%s' from Hostaway endpoint";
	const MESSAGE_OUT_OF_LIST  = "Provided '%s' value is out of the Hostaway's list";

	/**
	 * Executes the validation
	 *
	 * @param Validation $validation
	 * @param string $field
	 * @return bool
	 */
	public function validate(Validation $validation, $field)
	{
		$di = $validation->getDI();

		/** @var BackendInterface $cache */
		$cache = $di->get('cache');

		$val = $validation->getValue($field);
		if (!$val) return true;

		/** @var Client $client */
		$client   = $di->get('client');
		$hostaway = $di->get('config')->hostaway;

		if (!property_exists($hostaway->endpoints, $field)) {
			$this->addMessage($validation, self::MESSAGE_NO_ENDPOINTS, $field);

			return false;
		}

		$endpoint = $hostaway->endpoints->$field;
		$url      = $hostaway->baseApiUrl. $endpoint;

		if ($cache->exists($endpoint)) {
			/*
			 * Retrieving a list from a Redis cache
			 */
			$body = (array) $cache->get($endpoint);
		} else {
			/*
			 * Retrieving a list from an endpoint
			 */
			$resp = $client->request('GET', $url);
			$body = json_decode((string) $resp->getBody(), true);

			if ($resp->getStatusCode() != 200 || $body['status'] != 'success') {
				$this->addMessage($validation, self::MESSAGE_FETCH_ERROR, $endpoint);

				return false;
			}

			$cache->save($endpoint, $body, 3600);
		}

		if (!key_exists($val, $body['result'])) {
			$message = $this->getOption('message') ?: self::MESSAGE_OUT_OF_LIST;
			$this->addMessage($validation, $message, $field);

			return false;
		}

		return true;
	}

	/**
	 * @param Validation $validation
	 * @param string $message
	 * @param string $field
	 */
	private function addMessage(Validation &$validation, string $message, string $field)
	{
		$validation->appendMessage(new Message(sprintf($message, $field)));
	}
}
