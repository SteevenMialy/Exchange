<?php

namespace app\models;

use Flight;
use PDO;

class User
{
    private $id;
    private $username;
    private $pwd;

    public function __construct($username = null, $id = null, $pwd = null)
    {
        $this->username = $username;
        $this->id = $id;
        $this->pwd = $pwd;
    }

    public function insert($db): int
    {
        $sql = "INSERT INTO exch_user (username,pwd) 
                VALUES (:username, :pwd)";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':username' => $this->username,
            ':pwd' => $this->pwd
        ]);

        $this->id = $db->lastInsertId();
        return $this->id;
    }

    public static function findById($db, $id)
    {
        $sql = "SELECT * FROM exch_user WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countUser ($db) {
        $isa = 0;
        $sql = "SELECT COUNT(*) as user_count FROM exch_user";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $isa = (int)$result['user_count'];
        }
        return $isa;
    }

    public static function findAll($db)
    {
        $sql = "SELECT * FROM exch_user";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($db): bool
    {
        $sql = "UPDATE exch_user 
                SET username = :username , pwd = :pwd
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':username' => $this->username,
            ':id' => $this->id,
            ':pwd' => $this->pwd
        ]);
    }

    public function delete($db): bool
    {
        $sql = "DELETE FROM exch_user WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':id' => $this->id
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }
}
