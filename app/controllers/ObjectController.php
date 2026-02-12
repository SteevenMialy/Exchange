<?php

namespace app\controllers;

use app\models\User;
use Flight;
use flight\Engine;

class ObjectController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public static function getAllUsers()
	{
		$user = new User();
		$users = $user->findAll(Flight::db());
		return $users;
	}

	public static function getUser($id)
	{
		$user = new User();
		$user = $user->findById(Flight::db(), $id);
		return $user;
	}

	public static function getAllObjectUserCo($id_user)
	{
		$user = new User();
		return $user->myobject(Flight::db(), $id_user);
	}

	public static function totalUsers()
	{
		$user = new User();
		return $user->countUser(Flight::db());
	}

	public static function getObjectById($id)
	{
		$user = new User();
		return $user->findObjectById(Flight::db(), $id);
	}

}
