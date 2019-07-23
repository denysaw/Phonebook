<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Micro\Collection;
use App\Controllers\ItemsController;

/** @var Router $router */
$router = $app->getRouter();
$router->removeExtraSlashes(true);
$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
$app->setService('router', $router);

/**
 * Items Api Routes
 */
$items = new Collection();
$items->setHandler(ItemsController::class, true);
$items->setPrefix('/api/items');

/**
 * Retrieve single item by ID
 */
$items->get('/{id:[0-9]+}', 'getAction');

/**
 * Retrieve item list
 */
$items->get('/', 'searchAction');

/**
 * Retrieve count of all available items
 */
$items->get('/total', 'countAction');

/**
 * Add a new item
 */
$items->post('/', 'createAction');

/**
 * Edit an existing item
 */
$items->put('/{id:[0-9]+}', 'updateAction');
$items->patch('/{id:[0-9]+}', 'updateAction');

/**
 * Delete an item
 */
$items->delete('/{id:[0-9]+}', 'deleteAction');

$app->mount($items);

/**
 * Wrong endpoint route (404)
 */
$app->notFound(function() use ($app) {
	$app->response->setStatusCode(404, 'Not Found');
	$app->response->setJsonContent(['status' => 'error', 'message' => 'Wrong endpoint URL']);
	$app->response->send();
});
