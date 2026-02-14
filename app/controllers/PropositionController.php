<?php

namespace app\controllers;

use app\models\Proposition;

use Flight;
use flight\Engine;

class PropositionController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public static function proposeExchange()
    {
        $request = Flight::request();
        $data = $request->data->getData();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idUser = $_SESSION['user']->id;

        $proposition = new Proposition();
        $proposition->setIdUserOffered($idUser);
        $proposition->setIdObjectOffered($data['mine']);
        $proposition->setIdObjectRequested($data['target']);
        $proposition->setIdUserRequested($data['possessor']);
        $proposition->insert(Flight::db());

        Flight::json([
            'success' => true,
            'message' => 'Proposition créée avec succès'
        ]);
    }

}