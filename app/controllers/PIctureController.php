<?php

namespace app\controllers;

use app\models\ExchObject;
use app\models\Picture;
use Flight;
use flight\Engine;

class PIctureController
{
    protected Engine $app;
    
    public function __construct($app)
    {
        $this->app = $app;
    }

    public static function getPictureObject($idObjet)
    {
        $obj = new Picture();
        $objs = $obj->findByObjectId(Flight::db(), $idObjet);
        return $objs;
    }
    
}