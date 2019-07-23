<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

namespace App\Validation;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\StringLength;
use App\Validation\Validator\Hostaway;

/**
 * Class ItemsValidation
 * @package App\Validation
 */
class ItemsValidation extends Validation
{

	public function __construct()
	{
		parent::__construct();

		$this->add(
			['firstName', 'phone'],
			new PresenceOf(['message' => "Required field ':field' wasn't provided"])
		)->add(
			['firstName', 'lastName', 'phone', 'country', 'timezone'],
			new StringLength([
				'max' => [
					'firstName' => 30,
					'lastName'  => 40,
					'phone'     => 17,
					'country'   => 2,
					'timezone'  => 40
				],
				'messageMaximum' => "Field ':field' exceeds it's maximum length"
			])
		)->add(
			['firstName', 'lastName'],
			new Uniqueness(['message' => "Record with such ':field' already exists"])
		)->add(
			'phone',
			new Uniqueness(['message' => "Record with such ':field' already exists"])
		)->add(
			'phone',
			new Regex([
				'pattern' => '/^\+\d{1,3}\s\d{2,3}\s\d{7,10}$/',
				'message' => 'Provided phone has invalid format',
			])
		)->add(
			['country', 'timezone'],
			new Hostaway()
		);
	}
}
