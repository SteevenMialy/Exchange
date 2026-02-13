<?php

namespace app\controllers;

use app\models\User;
use Flight;
use flight\Engine;
use app\services\Validator;
use Throwable;

class UserController
{

	protected Engine $app;

    public static function check(){
        $user = new User();

        $req = Flight::request();

        $user->setUsername($req->data->username);
        $listUsers = $user->findUser(Flight::db());

        $pwd = (String) $req->data->password;
        $retour = null;
        foreach ($listUsers as $u) {
            if (password_verify($pwd, $u['pwd'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $retour = $u;
            }
        }
        
        if($retour != null){
            $_SESSION['user'] = $retour;
            Flight::redirect('/home');
        } else {
            Flight::json([
                'ok' => false,
                'errors' => [
                    'username' => '',
                    'password' => 'Nom d\'utilisateur ou mot de passe incorrect.'
                ],
                'values' => []
            ]);
        }

        return;
    }

    public static function save(){
        $user = new User();

        $req = Flight::request();

        $hashedPassword = password_hash($req->data->password, PASSWORD_DEFAULT);
        $user->setUsername($req->data->username);
        $user->setPassword($hashedPassword);

        $user->insert(Flight::db());

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user'] = $user;

        Flight::redirect('/home');
    }

	public static function validateSignin()
    {
        header('Content-Type: application/json; charset=utf-8');
		try {
            $repo = new User();

            $req = Flight::request();

            $input = [
                'username' => $req->data->username ?? '',
                'password' => $req->data->password ?? '',
                'confirmPassword' => $req->data->passwordconfirmation ?? '',
            ];

            $res = Validator::validateRegister($input, $repo);

            Flight::json([
                'ok' => $res['ok'],
                'errors' => $res['errors'],
                'values' => $res['values'],
            ]);
        } catch (Throwable $e) {
            error_log("Erreur validation: " . $e->getMessage());
            error_log($e->getTraceAsString());
            http_response_code(500);
            Flight::json([
                'ok' => false,
                'errors' => ['_global' => 'Erreur serveur: ' . $e->getMessage()],
                'values' => []
            ]);
        }
	}

    public static function validateLogin()
    {
        header('Content-Type: application/json; charset=utf-8');
		try {
            $repo = new User();

            $req = Flight::request();

            $input = [
                'username' => $req->data->username ?? '',
                'password' => $req->data->password ?? '',
            ];

            $res = Validator::validateLogin($input, $repo);

            Flight::json([
                'ok' => $res['ok'],
                'errors' => $res['errors'],
                'values' => $res['values'],
            ]);
        } catch (Throwable $e) {
            error_log("Erreur validation: " . $e->getMessage());
            error_log($e->getTraceAsString());
            http_response_code(500);
            Flight::json([
                'ok' => false,
                'errors' => ['_global' => 'Erreur serveur: ' . $e->getMessage()],
                'values' => []
            ]);
        }
	}
	
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

	public static function totalUsers()
	{
		$user = new User();
		return $user->countUser(Flight::db());
	}
}