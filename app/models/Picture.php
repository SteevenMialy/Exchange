<?php

namespace app\models;

use PDO;

class Picture
{
    public $id;
    private $id_object;
    private $path_img;

    public function __construct($id = null, $id_object = null, $path_img = null)
    {
        $this->id = $id;
        $this->id_object = $id_object;
        $this->path_img = $path_img;
    }

    public static function findById($db, $id): ?Picture
    {
        $sql = "SELECT * FROM exch_pictures WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Picture($row['id'], $row['id_object'], $row['path_img']);
        }
        return null;
    }

    public static function findAll($db): array
    {
        $sql = "SELECT * FROM exch_pictures";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $pictures = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pictures[] = new Picture($row['id'], $row['id_object'], $row['path_img']);
        }
        return $pictures;
    }

    public static function findByObjectId($db, $id_object): array
    {
        $sql = "SELECT * FROM exch_pictures WHERE id_object = :id_object";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_object' => $id_object
        ]);

        $pictures = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pictures[] = new Picture($row['id'], $row['id_object'], $row['path_img']);
        }
        return $pictures;
    }

    public function insert($db, $id_object, array $path_imgs): int
    {
        $sql = "INSERT INTO exch_pictures (id_object, path_img) 
                VALUES (:id_object, :path_img)";

        $stmt = $db->prepare($sql);
        foreach ($path_imgs as $path_img) {
            $stmt->execute([
                ':id_object' => $id_object,
                ':path_img'  => $path_img
            ]);
        }

        $this->id = $db->lastInsertId();
        return $this->id;
    }

    public function update($db,$data): bool
    {
        $sql = "UPDATE exch_pictures 
                SET id_object = :id_object, path_img = :path_img
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id_object' => $this->id_object,
            ':path_img' => $this->path_img,
            ':id' => $this->id
        ]);
    }

    public function delete($db): bool
    {
        $sql = "DELETE FROM exch_pictures WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':id' => $this->id
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdObject()
    {
        return $this->id_object;
    }

    public function setIdObject($id_object)
    {
        $this->id_object = $id_object;
    }

    public function getPathImg()
    {
        return $this->path_img;
    }

    public function setPathImg($path_img)
    {
        $this->path_img = $path_img;
    }
}