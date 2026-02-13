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
        $pwd = Flight::request()->data->pwd;
        $id_user= $_SESSION['user']->id;
        $admin = new Admin();

        if ($admin->verifiemdp($pwd,$id_user)) {
            Flight::json([
                'success' => true,
                'redirectUrl' => BASE_URL . '/AdminPage'
            ]);

        } else {
            Flight::json([
                'success' => false,
                'error' => 'Mot de passe incorrect & id_user = ' . $id_user
            ], 401);
        }
    }
    
}
