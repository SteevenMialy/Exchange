<?php

use app\controllers\CategoryController;
use app\controllers\UserController;
use app\controllers\ObjectController;
use app\controllers\AdminController;
use app\controllers\DetailController;
use app\controllers\PictureControlleur;

use app\middlewares\SecurityHeadersMiddleware;
use app\models\Category;
use flight\Engine;
use flight\net\Router;

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	$router->get('/', function () use ($app) {
		$app->render('login');
	});

	$router->get('/newcategory', function () use ($app) {
		$app->render('InsertCategory');
	});

	$router->post('/insertioncategory', function () use ($app) {
		$controller = new CategoryController($app);
		$controller->insertcategory();
		Flight::redirect('/adminpage');
	});

	$router->get('/editcategory/@id', function ($id) use ($app) {
		$controller = new CategoryController($app);
		$app->render('modifycategory', [
			'category' => CategoryController::find($id)
		]);
	});

	$router->post('/modificationcategory', function () use ($app) {
		$controller = new CategoryController($app);
		$controller->modifycategory();
		Flight::redirect('/adminpage');
	});


	$router->get('/signin', function () use ($app) {
		$app->render('signin');
	});

	$router->get('/disconnect', function () use ($app) {
		if (session_status() === PHP_SESSION_ACTIVE) {
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(
					session_name(),
					'',
					time() - 42000,
					$params["path"],
					$params["domain"],
					$params["secure"],
					$params["httponly"]
				);
			}

			session_destroy();
			Flight::redirect('/');
		}
	});

	Flight::route('/api/validate/signin', [UserController::class, 'validateSignin']);
	Flight::route('/signIn', [UserController::class, 'save']);

	Flight::route('/api/validate/login', [UserController::class, 'validateLogin']);
	Flight::route('/login', [UserController::class, 'check']);

	$router->get('/home', function () use ($app) {
		$id = $_SESSION['user']->id ?? null;
		$controller = new ObjectController($app);
		$app->render('home', [
			'objects' => ObjectController::getAllBelongedObject($id)
		]);
	});

	$router->get('/adminpage', function () use ($app) {
		$controller = new CategoryController($app);
		$app->render('AdminPage', [
			'categories' => CategoryController::allcategory()
		]);
	});

	$router->get('/shop', function () use ($app) {
		$app->render('shop');
	});

	$router->get('/shopCart', function () use ($app) {
		$app->render('cart');
	});

	$router->get('/checkout', function () use ($app) {
		$app->render('checkout');
	});

	$router->get('/contact', function () use ($app) {
		$app->render('contact');
	});

	$router->post('/connect/admin', function () use ($app) {
		$controller = new AdminController($app);
		$controller->authenticateAdmin();
	});

	$router->get('/Accueil', function () use ($app) {
		$objects = ObjectController::getAllBelongedObject();
		$pictures = [];
		foreach ($objects as $obj) {
			if (!is_array($obj) || !isset($obj['id'])) {
				continue;
			}
			$pictures[$obj['id']] = PictureControlleur::getPicturesByObjectId($obj['id']);
		}
		$app->render('Accueil', [
			'objects'  => $objects,
			'pictures' => $pictures
		]);
	});

	$router->get('/ajoutobject', function () use ($app) {
		$db = Flight::db();
		$categories = new CategoryController($app);
		$catArray = [];
		$catArray=$categories->allcategory() ;
		$app->render('ajoutobject', [
			'categories' => $catArray
		]);
	});

	$router->post('/ajoutobjectfonc', function () use ($app) {
		$controller = new ObjectController($app);
		$idobject = $controller->insertionobject();

		if (!empty($idobject)) {
			// Insérer les images associées à l'objet
			PictureControlleur::insertionpicture($idobject);

			$objects = ObjectController::getAllBelongedObject();
			$pictures = [];
			foreach ($objects as $obj) {
				if (!is_array($obj) || !isset($obj['id'])) {
					continue;
				}
				$pictures[$obj['id']] = PictureControlleur::getPicturesByObjectId($obj['id']);
			}
			$app->render('Accueil', [
				'objects'  => $objects,
				'pictures' => $pictures
			]);
		} else {
			$app->render('ajoutobject', [
				'categories' => CategoryController::allcategory()
			]);
		}
		
	});



	$router->get('/details/@id', function ($id) use ($app) {
		$controller = new ObjectController($app);
		$object = $controller->getObject($id);
		$pictures = PictureControlleur::getPicturesByObjectId($id);
		$app->render('details', [
			'object' => $object,
			'pictures' => $pictures
		]);
	});
}, [SecurityHeadersMiddleware::class]);
