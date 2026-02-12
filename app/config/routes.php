<?php

use app\controllers\UserController;
use app\controllers\ObjectController;
use app\middlewares\SecurityHeadersMiddleware;
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
			'objects' => ObjectController::getAllObjectUserCo($id)
		]);
	});

	$router->get('/adminpage', function () use ($app) {
		$app->render('AdminPage');
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
}, [SecurityHeadersMiddleware::class]);
