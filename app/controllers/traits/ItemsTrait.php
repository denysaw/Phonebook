<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

namespace App\Controllers\Traits;

use App\Models\Items;

/**
 * Trait ItemsTrait
 * @package App\Controllers\Traits
 */
trait ItemsTrait
{

	/**
	 * @param int $id
	 * @return Items|null
	 */
	private function getItemById(int $id): ?Items
	{
		/** @var Items $item */
		$item = Items::findFirst($id);

		if (!$item) {
			$this->response->setStatusCode(404, 'Not Found');
			$this->send(['status' => 'error', 'messages' => "There's no item with such ID"]);
		}

		return $item;
	}

	/**
	 * @return array
	 */
	private function getJsonBody(): array
	{
		$body = $this->request->getJsonRawBody(true);
		return array_diff_key($body, array_flip(Items::PROTECTED_FIELDS));
	}
}