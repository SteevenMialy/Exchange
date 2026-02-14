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

    public static function insertionpicture($idobject)
    {
        $uploadedNames = [];
        if (isset($_FILES['photos']['name']) && is_array($_FILES['photos']['name'])) {
            $count = count($_FILES['photos']['name']);
            for ($i = 0; $i < $count; $i++) {
                if ($_FILES['photos']['error'][$i] === UPLOAD_ERR_OK) {
                    $photoName   = basename($_FILES['photos']['name'][$i]);
                    $tmpName     = $_FILES['photos']['tmp_name'][$i];
                    $destination = 'uploads/object/' . $photoName;
                    move_uploaded_file($tmpName, $destination);
                    $uploadedNames[] = $photoName;
                }
            }
        } elseif (isset($_FILES['photos']['name']) && $_FILES['photos']['error'] === UPLOAD_ERR_OK) {
            // Cas d'un seul fichier
            $photoName   = basename($_FILES['photos']['name']);
            $tmpName     = $_FILES['photos']['tmp_name'];
            $destination = 'uploads/object/' . $photoName;
            move_uploaded_file($tmpName, $destination);
            $uploadedNames[] = $photoName;
        }
        $db = Flight::db();
        // 3) Insérer les images dans exch_pictures
        if (!empty($uploadedNames)) {
            $picture = new Picture();
            $picture->insert($db, $idobject, $uploadedNames);
        }

    }
    
}