<?php

namespace app\models;

use PDO;

class Categorie
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($nomcategory)
    {
        $stmt = $this->db->prepare("INSERT INTO exch_category (nomcategory) VALUES (?)");
        $stmt->bindParam(1, $nomcategory, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getAllCategorie()
    {
        $stmt = $this->db->query("SELECT * FROM exch_category");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategorieById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM exch_category WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nomcategory)
    {
        $stmt = $this->db->prepare("UPDATE exch_category SET nomcategory = ? WHERE id = ?");
        $stmt->bindParam(1, $nomcategory, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM exch_category WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}