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
        $admin = new Admin();
        $admin->setPwd($pwd);
        if ($admin->verifiemdp($pwd)) {
            Flight::json([
                'success' => true,
                'redirectUrl' => BASE_URL . 'adminpage'
            ]);
        } else {
            Flight::json([
                'success' => false,
                'error' => 'Mot de passe incorrect'
            ], 401);
        }
    }
    
}
