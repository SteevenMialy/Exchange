<?php

namespace app\models;

use PDO;

class Category
{
    public $id;
    private $nomcategory;

    public function __construct($id = null, $nomcategory = null)
    {
        $this->id = $id;
        $this->nomcategory = $nomcategory;
    }

    public static function findById($db, $id): ?Category
    {
        $sql = "SELECT * FROM exch_category WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Category($row['id'], $row['nomcategory']);
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
            $categories[] = new Category($row['id'], $row['nomcategory']);
        }
        return $categories;
    }

    public function insert($db): int
    {
        $sql = "INSERT INTO exch_category (nomcategory) 
                VALUES (:nomcategory)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nomcategory' => $this->nomcategory
        ]);

        $this->id = $db->lastInsertId();
        return $this->id;
    }

    public function update($db): bool
    {
        $sql = "UPDATE exch_category 
                SET nomcategory = :nomcategory
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':nomcategory' => $this->nomcategory,
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
}