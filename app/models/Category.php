<?php

namespace app\models;

use PDO;

class Category
{
    public $id;
    private $nomcategory;
    private $img;

    public function __construct($id = null, $nomcategory = null, $img = null)
    {
        $this->id = $id;
        $this->nomcategory = $nomcategory;
        $this->img = $img;
    }

    public static function findById($db, $id): ?Category
    {
        $sql = "SELECT * FROM exch_category WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Category($row['id'], $row['nomcategory'], $row['path_img']);
        }
        return null;
    }


    public static function findAll($db): array
    {
        $sql = "SELECT * FROM exch_category";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category(
                $row['id'],
                $row['nomcategory'],
                $row['path_img']  // ← récupérer correctement le path
            );
        }
        return $categories;
    }


    public function insert($db): int
    {
        // Dossier d’upload
        $uploadDir = "uploads/category/";

        // Créer le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Gestion image
        if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === 0) {

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (!in_array($_FILES['img_path']['type'], $allowedTypes)) {
                throw new Exception("Type d'image non autorisé.");
            }

            // Générer un nom unique
            $extension = pathinfo($_FILES['img_path']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("cat_", true) . "." . $extension;

            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['img_path']['tmp_name'], $targetFile)) {
                $this->img = $filename;
            } else {
                throw new Exception("Erreur lors de l'upload de l'image.");
            }

        } else {
            $this->img = null;
        }

        // Requête SQL
        $sql = "INSERT INTO exch_category (nomcategory, path_img) 
            VALUES (:nomcategory, :path_img)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nomcategory' => $this->nomcategory,
            ':path_img' => $this->img
        ]);

        $this->id = $db->lastInsertId();
        return $this->id;
    }




    public function update($db): bool
    {
        $sql = "UPDATE exch_category 
            SET nomcategory = :nomcategory, 
                path_img = :path_img
            WHERE id = :id";

        $stmt = $db->prepare($sql);

        // Si tu veux garder l'image existante si aucune nouvelle image n'est uploadée
        if (!isset($this->img)) {
            // Récupérer l'image actuelle en DB
            $current = self::findById($db, $this->id);
            $this->img = $current ? $current->getImg() : null;
        }

        return $stmt->execute([
            ':nomcategory' => $this->nomcategory,
            ':path_img' => $this->img,
            ':id' => $this->id
        ]);
    }


    public function delete($db): bool
    {
        $sql = "DELETE FROM exch_category WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':id' => $this->id
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNomCategory()
    {
        return $this->nomcategory;
    }

    public function setNomCategory($nomcategory)
    {
        $this->nomcategory = $nomcategory;
    }

    public function setImg($img)
    {
        $this->img = $img;
    }

    public function getImg()
    {
        return $this->img;
    }


}