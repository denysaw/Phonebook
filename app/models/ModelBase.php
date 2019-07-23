<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

namespace App\Models;

use Phalcon\Mvc\Model;

/**
 * Class ModelBase
 * @package App\Models
 */
abstract class ModelBase extends Model
{

	public function initialize()
	{
		$this->keepSnapshots(true);
	}

	public function beforeSave()
	{
		if (property_exists($this, 'updatedOn')) {
			/** @noinspection PhpUndefinedMethodInspection */
			$this->setUpdatedOn(date("Y-m-d H:i:s"));
		}
	}

	/**
	 * @return array
	 */
	public function messages(): array
	{
		return array_map(function($message) {
			return (string) $message;
		}, $this->getMessages());
	}
}