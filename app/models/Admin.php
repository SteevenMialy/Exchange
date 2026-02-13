<?php

namespace app\models;

use Flight;
use PDO;

class Admin
{
    private $id;
    private $id_user;
    private $pwd;

    public function __construct($id_user = null, $pwd = null, $id = null)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->pwd = $pwd;
    }

    public function insert($db): int
    {
        $sql = "INSERT INTO exch_admin (id_user, pwd) 
                VALUES (:id_user, :pwd)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $this->id_user,
            ':pwd'     => $this->pwd
        ]);

        $this->id = $db->lastInsertId();
        return $this->id;
    }

    public static function findById($db, $id)
    {
        $sql = "SELECT * FROM exch_admin WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findAll($db)
    {
        $sql = "SELECT * FROM exch_admin";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($db): bool
    {
        $sql = "UPDATE exch_admin 
                SET id_user = :id_user,
                    pwd = :pwd
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id_user' => $this->id_user,
            ':pwd'     => $this->pwd,
            ':id'      => $this->id
        ]);
    }

    public function delete($db): bool
    {
        $sql = "DELETE FROM exch_admin WHERE id = :id";
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

    public function getPwd()
    {
        return $this->pwd;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    public function verifiemdp($pwd, $id_user)
    {
        $db = Flight::db();
        $sql = "SELECT * FROM exch_admin where id_user IN (SELECT id FROM exch_user) AND pwd=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$pwd]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            return true;
        } else {
            return false;
        }

    }
}
