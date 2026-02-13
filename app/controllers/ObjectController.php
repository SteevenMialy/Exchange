<?php

namespace app\controllers;

use app\models\ExchObject;
use Flight;
use flight\Engine;

class ObjectController
{

	protected Engine $app;
	
	public function __construct($app)
	{
		$this->app = $app;
	}

	public static function getAllBelongedObject()
	{
		$obj = new ExchObject();
		$objs = $obj->findBelongedObject(Flight::db());
		return $objs;
	}

	public static function getAllNotBelongedObject()
	{
		$obj = new ExchObject();
		$objs = $obj->findNotBelongedObject(Flight::db());
		return $objs;
	}

	public static function getObject($id)
	{
		$obj = new ExchObject();
		$objs = $obj->findById(Flight::db(), $id);
		return $objs;
	}
	
}