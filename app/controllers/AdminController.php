<?php

namespace app\controllers;

use app\models\User;
use app\models\Admin;

use Flight;
use flight\Engine;

class AdminController
{

    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }



    public static function authenticateAdmin()
    {
        session_start();

        $pwd = Flight::request()->data->pwd ?? Flight::request()->data['pwd'] ?? $_POST['pwd'] ?? null;
        $id_user = $_SESSION["user"]->id;
        
        if (empty($pwd)) {
            Flight::json([
                'success' => false,
                'error' => 'Mot de passe manquant'
            ], 400);
            return;
        }
        
        $admin = new Admin();
        if ($admin->verifiemdp($pwd, $id_user, Flight::db())) { 
            Flight::json([
                'success' => true,
                'redirectUrl' => BASE_URL . 'AdminPage'
            ]);
        } else {
            Flight::json([
                'success' => false,
                'error' => 'Mot de passe incorrect'
            ], 401);
        }

    }


    
}
