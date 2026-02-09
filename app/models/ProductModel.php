<?php

namespace app\Models;

use flight;

class ProductModel
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProduits() {
        return $this->db->fetchAll("SELECT * FROM produit");
        // $stmt = $this->db->query("SELECT * FROM produit");
        // return $stmt->fetch();
    }

    public function getProduit($id) {
        /* $stmt = $this->db->query("SELECT * FROM produit WHERE id = $id ");
        return $stmt->fetch(); */
         return $this->db->query("SELECT * FROM produit WHERE id = $id ");
    }

    

}






?>