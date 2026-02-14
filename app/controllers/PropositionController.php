<?php

namespace app\controllers;

use app\models\Proposition;
use app\models\Exchange;

use Flight;
use flight\Engine;

class PropositionController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public static function acceptProposal($idProposal)
    {
        $proposal = Proposition::findById(Flight::db(), $idProposal);
        if ($proposal) {
            $db = Flight::db();
            $proposal->accept($db);
            $exchange = new Exchange();
            $exchange->proposition = $proposal;
            $exchange->insert($db);
            Flight::json([
                'success' => true,
                'message' => 'Proposition acceptée avec succès'
            ]);
        } else {
            Flight::json([
                'success' => false,
                'message' => 'Proposition non trouvée'
            ]);
        }
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

    public static function getPropositionsSent()
    {
        $idUser = $_SESSION['user']->id;
        $propositions = Proposition::findProposalSent(Flight::db(), $idUser);
        return $propositions;
    }

    public static function getPropositionsReceived()
    {
        $idUser = $_SESSION['user']->id;
        $propositions = Proposition::findProposalReceived(Flight::db(), $idUser);
        return $propositions;
    }

    public static function allconts($idUser){
        $db = Flight::db();
        $counts = [];
        $counts['sent'] = Proposition::countProposalSent($db, $idUser);
        $counts['received'] = Proposition::countProposalReceived($db, $idUser);
        return $counts;
    }

}