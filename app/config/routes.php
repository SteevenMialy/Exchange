<?php

use app\controllers\UserController;
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

	Flight::route('/api/validate/login', [UserController::class, 'validateLogin']);

	$router->get('/home', function () use ($app) {
		$app->render('home');
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