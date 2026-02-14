<?php

namespace app\models;

use PDO;

class Exchange
{
    public $id;
    private $id_proposition;
    private $date_exchange;

    /* Champs issus de la vue */
    private $id_object_offered;
    private $id_object_requested;
    private $offered_obj_name;
    private $requested_obj_name;
    private $offered_username;
    private $requested_username;

    public function __construct(
        $id = null,
        $id_proposition = null,
        $date_exchange = null,
        $id_object_offered = null,
        $id_object_requested = null,
        $offered_obj_name = null,
        $requested_obj_name = null,
        $offered_username = null,
        $requested_username = null
    ) {
        $this->id = $id;
        $this->id_proposition = $id_proposition;
        $this->date_exchange = $date_exchange;
        $this->id_object_offered = $id_object_offered;
        $this->id_object_requested = $id_object_requested;
        $this->offered_obj_name = $offered_obj_name;
        $this->requested_obj_name = $requested_obj_name;
        $this->offered_username = $offered_username;
        $this->requested_username = $requested_username;
    }

    /* ===================== FIND ===================== */

    public static function findAll($db): array
    {
        $sql = "SELECT * FROM v_exchange_history ORDER BY date_exchange DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $history = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $history[] = self::mapRowToObject($row);
        }
        return $history;
    }

    public static function findById($db, $id)
    {
        $sql = "SELECT * FROM v_exchange_history WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return self::mapRowToObject($row);
        }
        return null;
    }

    public static function findByUser($db, $id_user): array
    {
        $sql = "SELECT * FROM v_exchange_history
                WHERE offered_username = (
                    SELECT username FROM exch_user WHERE id = :id_user
                )
                OR requested_username = (
                    SELECT username FROM exch_user WHERE id = :id_user
                )";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user
        ]);

        $history = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $history[] = self::mapRowToObject($row);
        }
        return $history;
    }

    /* ===================== INSERT ===================== */

    public function insert($db): int
    {
        $sql = "INSERT INTO exch_exchange_history (id_proposition)
                VALUES (:id_proposition)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_proposition' => $this->id_proposition
        ]);

        $this->id = $db->lastInsertId();
        return $this->id;
    }

    /* ===================== MAPPER ===================== */

    private static function mapRowToObject($row): Exchange{
        return new Exchange(
            $row['id'],
            $row['id_proposition'],
            $row['date_exchange'],
            $row['id_object_offered'],
            $row['id_object_requested'],
            $row['offered_obj_name'],
            $row['requested_obj_name'],
            $row['offered_username'],
            $row['requested_username']
        );
    }

    /* ===================== GETTERS ===================== */

    public function getId() { return $this->id; }

    public function getIdProposition() { return $this->id_proposition; }
    public function setIdProposition($id) { $this->id_proposition = $id; }

    public function getDateExchange() { return $this->date_exchange; }

    public function getIdObjectOffered() { return $this->id_object_offered; }
    public function getIdObjectRequested() { return $this->id_object_requested; }

    public function getOfferedObjName() { return $this->offered_obj_name; }
    public function getRequestedObjName() { return $this->requested_obj_name; }

    public function getOfferedUsername() { return $this->offered_username; }
    public function getRequestedUsername() { return $this->requested_username; }
}
