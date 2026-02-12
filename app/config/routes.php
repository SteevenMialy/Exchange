<?php

use app\controllers\UserController;
use app\controllers\ObjectController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

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

	Flight::route('/api/validate/signin', [UserController::class, 'validateSignin']);
	Flight::route('/signIn', [UserController::class, 'save']);

	$router->get('/home', function ($id) use ($app) {
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