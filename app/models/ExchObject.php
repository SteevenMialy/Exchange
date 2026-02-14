<?php

namespace app\models;

use PDO;

class ExchObject
{
    public $id;
    private $id_user;
    private $id_category;
    private $descript;
    private $prix;
    private $obj_name;
    public $pictures = [];

    public function __construct($id = null, $id_user = null, $id_category = null, $descript = null, $prix = null, $obj_name = null)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_category = $id_category;
        $this->descript = $descript;
        $this->prix = $prix;
        $this->obj_name = $obj_name;
    }

    public function findObject($db, $conditions = [])
    {
        $sql = "SELECT * FROM exch_object WHERE 1=1";
        $params = [];
        if ($this->id_user !== null) {
            $sql .= " AND id_user = :id_user";
            $params[':id_user'] = $this->id_user;
        }
        if ($this->id_category !== null) {
            $sql .= " AND id_category = :id_category";
            $params[':id_category'] = $this->id_category;
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        $objects = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new ExchObject($row['id'], $row['id_user'], $row['id_category'], $row['descript'], $row['prix'], $row['obj_name']);
            $obj->pictures = Picture::findByObjectId($db, $obj->id);
            $objects[] = $obj;
        }
        return $objects;
    }

    public function findBelongedObject($db, $id_user): array
    {
        $sql = "SELECT * FROM exch_object WHERE id_user = :id_user";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findNotBelongedObject($db): array
    {
        $sql = "SELECT * FROM exch_object WHERE id_user != :id_user";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $this->id_user
        ]);

        $objects = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objects[] = new ExchObject($row['id'], $row['id_user'], $row['id_category'], $row['descript'], $row['prix'], $row['obj_name']);
        }
        return $objects;
    }

    public function insert($db,$data,$id_user): int
    {
        $sql = "INSERT INTO exch_object (id_user, id_category, descript, prix, obj_name) 
                VALUES (:id_user, :id_category, :descript, :prix, :obj_name)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user,
            ':id_category' => $data['id_category'],
            ':descript' => $data['descript'],
            ':prix' => $data['prix'],
            ':obj_name' => $data['obj_name']
        ]);

        $this->id = $db->lastInsertId();
        return $this->id;

    }

    public static function lastinsert($db): ?ExchObject
    {
         $id = $db->lastInsertId();
            if ($id) {
                return $id;
            }
        return null;
    }

    public static function findById($db, $id): ?Object
    {
        $sql = "SELECT * FROM exch_object WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ExchObject($row['id'], $row['id_user'], $row['id_category'], $row['descript'], $row['prix'], $row['obj_name']);
        }
        return null;
    }

    public static function findAll($db): array
    {
        $sql = "SELECT * FROM exch_object";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $objects = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objects[] = new ExchObject($row['id'], $row['id_user'], $row['id_category'], $row['descript'], $row['prix'], $row['obj_name']);
        }
        return $objects;
    }

    public function update($db): bool
    {
        $sql = "UPDATE exch_object 
                SET id_user = :id_user, id_category = :id_category, descript = :descript, prix = :prix, obj_name = :obj_name
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id_user' => $this->id_user,
            ':id_category' => $this->id_category,
            ':descript' => $this->descript,
            ':prix' => $this->prix,
            ':obj_name' => $this->obj_name,
            ':id' => $this->id
        ]);
    }

    public function delete($db): bool
    {
        $sql = "DELETE FROM exch_object WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':id' => $this->id
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getIdCategory()
    {
        return $this->id_category;
    }

    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;
    }

    public function getDescript()
    {
        return $this->descript;
    }

    public function setDescript($descript)
    {
        $this->descript = $descript;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function getObjName()
    {
        return $this->obj_name;
    }

    public function setObjName($obj_name)
    {
        $this->obj_name = $obj_name;
    }

   

}