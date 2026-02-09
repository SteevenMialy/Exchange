<?php

namespace app\Models;

use flight;

class Cooperativemodels
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /* public function getProduits() {
        return $this->db->fetchAll("SELECT * FROM produit");
        // $stmt = $this->db->query("SELECT * FROM produit");
        // return $stmt->fetch();
    }

    public function getProduit($id) {
        /* $stmt = $this->db->query("SELECT * FROM produit WHERE id = $id ");
        return $stmt->fetch(); */
    //return $this->db->query("SELECT * FROM produit WHERE id = $id ");
    //} */

    public function InsertDonnees($data)
    {
        $sql = "INSERT INTO trajet (idvehicule,idchauffeur,distancetrajet,datytrajet,heuredebut,heurefin,MontantRecette,MontantCarburant) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['vehicule'] ?? null,
            $data['chauffeur'] ?? null,
            $data['distanceT'] ?? 0,
            $data['dateT'] ?? null,
            $data['debutT'] ?? null,
            $data['finT'] ?? null,
            $data['Mrecette'] ?? 0,
            $data['Mcarburant'] ?? 0
        ]);
    }

    public function selectvehicule()
    {
        return $this->db->fetchAll("SELECT * FROM vehicule");
    }

    public function selectchauffeur()
    {
        return $this->db->fetchAll("SELECT * FROM chauffeur");
    }

    public function TrajetRentableParJour()
    {
        return $this->db->fetchAll("SELECT 
        DATE(datytrajet) AS jour,
            idtrajet,
            MontantRecette,
            MontantCarburant,
            (MontantRecette - MontantCarburant) AS marge
        FROM trajet
        WHERE (MontantRecette - MontantCarburant) > 0
        ORDER BY DATE(datytrajet), (MontantRecette - MontantCarburant) DESC;");
    }

    public function getvoitureParj($daty)
    {
        // return $this->db->fetchAll("SELECT SUM(distancetrajet) as Km,SUM(MontantCarburant) as MontantCardbu, SUM(MontantRecette) as Recette FROM trajet where datytrajet = ? ");
        $sql = "SELECT 
        SUM(t.distancetrajet) AS Km,
        SUM(t.MontantCarburant) AS MontantCarburant,
        SUM(t.MontantRecette) AS Recette,
        v.idvehicule,
        c.nomchauffeur
    FROM trajet t
    JOIN vehicule v ON v.idvehicule = t.idvehicule
    JOIN chauffeur c ON c.idchauffeur = t.idchauffeur
    WHERE t.datytrajet = ?
    GROUP BY v.idvehicule, c.nomchauffeur
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$daty]);
        return $stmt->fetchAll();
    }

    public function Montantbenefic()
    {
        $sql = "SELECT   SUM(t.MontantRecette) - SUM(t.MontantCarburant) AS Benefice , v.idvehicule
        FROM trajet t JOIN vehicule v ON v.idvehicule = t.idvehicule GROUP BY v.idvehicule
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function MontantbeneficParJ()
    {
        $sql = "SELECT 
            t.idvehicule,
            t.datytrajet,
            SUM(t.MontantRecette) AS TotalRecette,
            SUM(t.MontantCarburant) AS TotalCarburant,
            SUM(t.MontantRecette) - SUM(t.MontantCarburant) AS Benefice
        FROM trajet t
        GROUP BY t.datytrajet
        ORDER BY t.datytrajet

        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function VoitureDispo($daty)
    {
        if (!$daty) {
            return [];
        }

        $sql = "SELECT v.idvehicule, v.nomvehicule
            FROM vehicule v
            WHERE v.idvehicule NOT IN (
                SELECT p.idvehicule
                FROM panne p
                WHERE p.datedebut <= ?
                AND (p.datefin IS NULL OR p.datefin >= ?)
            )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$daty, $daty]);

        return $stmt->fetchAll();
    }



}






?>