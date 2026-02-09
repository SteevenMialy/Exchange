<?php

use app\controllers\Cooperativecontroller;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	/* $router->get('/insert', function () use ($app) {

		$model = new \app\models\Cooperativemodels(Flight::db());

		$vehicules = $model->selectvehicule();
		$chauffeurs = $model->selectchauffeur();

		$app->render('insertion', [
			'vehicules' => $vehicules,
			'chauffeurs' => $chauffeurs
		]);
	});


	$router->post('/insertionbase', function () use ($app) {
		$controller = new \app\controllers\Cooperativecontroller($app);
		$controller->insertdonnees();
	}); */


	$router->get('/', function () use ($app) {
		$app->render('index', ['message' => 'Bienvenue sur la page d’accueil']);
	});

	/* $router->get('/trajetrentable', function () use ($app) {
		$app->render('Trajet', ['trajetR' => Cooperativecontroller::TrajetRentableParJour()]);
	});

	$router->get('/VoitureDispo', function () use ($app) {
		$controller = new app\controllers\Cooperativecontroller($app);
		$controller->VoitureDisp();
	});


	$router->get('/ListevoitureParJ', function () use ($app) {
		$controller = new app\controllers\Cooperativecontroller($app);
		$controller->getListV();
	});

	$router->get('/BeneficeVoiture', function () use ($app) {
		$controller = new app\controllers\Cooperativecontroller($app);
		$controller->Benefice();
	});

	$router->get('/BeneficeJour', function () use ($app) {
		$controller = new app\controllers\Cooperativecontroller($app);
		$controller->BeneficeJournaliere();
	}); */


	/* $router->get('/', function() use ($app) {
		$app->render('accueil', [ 'products' => ApiProjectDbController::getProducts() ]);
	});

	$router->get('/produit/@id:[0-9]', function($id) use ($app) {
		$app->render('produit', [ 'product' => ApiProjectDbController::getProduct($id) ]);
	});
 */
	/* $router->group('/api', function() use ($router) {
		$router->get('/users', [ ApiExampleController::class, 'getUsers' ]);
		$router->get('/users/@id:[0-9]', [ ApiExampleController::class, 'getUser' ]);
		$router->post('/users/@id:[0-9]', [ ApiExampleController::class, 'updateUser' ]);
	}); */

}, [SecurityHeadersMiddleware::class]);