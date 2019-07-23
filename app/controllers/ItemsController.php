<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Items;
use App\Controllers\Traits\ItemsTrait;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * Annotations are written in a case app will grow from Micro to Simple
 * and will start to use Router\Annotations
 *
 * @RoutePrefix('/api/items')
 */
final class ItemsController extends ApiController
{

	use ItemsTrait;

	/**
	 * @Get('/{id:[0-9]+}')
	 */
	public function getAction(int $id)
	{
		$this->checkIfCached();

		$item = $this->getItemById($id);
		$resp = ['status' => 'success', 'item' => $item];

		$this->storeInCache($resp);
		$this->send($resp);
	}

	/**
	 * @Get('/')
	 */
	public function searchAction()
	{
		$this->checkIfCached();

		$query = (string) $this->request->get('q');
		$limit = $this->request->get('l') ?? 100;
		$page  = (int) $this->request->get('p') ?: 1;

		$builder = Items::query()->createBuilder();

		if ($query) {
			$builder->where("FULLTEXT_MATCH_BMODE(firstName, lastName, ?0)", [$query. '*']);
		}

		$paginator = new QueryBuilder([
			"builder" => $builder,
			"limit"   => $limit,
			"page"    => $page,
		]);

		$items = $paginator->getPaginate();
		$items->status = 'success';

		$this->storeInCache($items);
		$this->send($items);
	}

	/**
	 * @Get('/total')
	 */
	public function countAction()
	{
		$this->checkIfCached();

		$resp = ['status' => 'success', 'totalItems' => Items::count()];

		$this->storeInCache($resp);
		$this->send();
	}

	/**
	 * @Post('/')
	 */
	public function createAction()
	{
		$this->flushCache();

		$item = new Items($this->getJsonBody());

		if (!$item->create()) {
			$this->log($item->messages());
			$this->send(['status' => 'error', 'messages' => $item->messages()]);
		}

		$this->send(['status' => 'success', 'id' => $item->getId()]);
	}

	/**
	 * @Route('/{id:[0-9]+}', methods={'PUT', 'PATCH'})
	 *
	 * @param int $id
	 */
	public function updateAction(int $id)
	{
		$item = $this->getItemById($id);

		$this->flushCache();

		if (!$item->save($this->getJsonBody())) {
			$this->log($item->messages());
			$this->send(['status' => 'error', 'messages' => $item->messages()]);
		}

		$updated = array_diff($item->getUpdatedFields(), ['updatedOn']);

		$this->send(['status' => 'success', 'updated' => $updated]);
	}

	/**
	 * @Route('/{id:[0-9]+}', methods={'DELETE', 'PURGE'})
	 *
	 * @param int $id
	 */
	public function deleteAction(int $id)
	{
		$item = $this->getItemById($id);

		if (!$item->delete()) {
			$this->log($item->messages());
			$this->send(['status' => 'error', 'messages' => $item->messages()]);
		}

		$this->flushCache();
		$this->send(['status' => 'success']);
	}
}
