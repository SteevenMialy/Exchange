<?php

namespace app\controllers;

use app\models\ProductModel;
use flight\Engine;

class ApiExampleController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public static function getProducts()
	{
		// You could actually pull data from the database if you had one set up
		// $users = $this->app->db()->fetchAll("SELECT * FROM users");
		$produit = new ProductModel();
		$prod = $produit->getProducts();

		// You actually could overwrite the json() method if you just wanted to
		// to ->json($users); and it would auto set pretty print for you.
		// https://flightphp.com/learn#overriding
		return $prod;
	}

	public static function getProduct($id)
	{
		// You could actually pull data from the database if you had one set up
		// $user = $this->app->db()->fetchRow("SELECT * FROM users WHERE id = ?", [ $id ]);
		$produit = new ProductModel();
		$prod = $produit->getProduct($id);
		/* $users_filtered = array_filter($prod, function ($data) use ($id) {
			return $data['id'] === (int) $id;
		});
		if ($users_filtered) {
			$user = array_pop($users_filtered);
		} */
		return $prod;
	}

	/* public function updateUser($id)
	{
		// You could actually update data from the database if you had one set up
		// $statement = $this->app->db()->runQuery("UPDATE users SET email = ? WHERE id = ?", [ $this->app->data['email'], $id ]);
		$this->app->json(['success' => true, 'id' => $id], 200, true, 'utf-8', JSON_PRETTY_PRINT);
	} */
}