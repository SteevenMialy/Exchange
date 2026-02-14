<?php

namespace app\models;

use PDO;

class Proposition
{
    public $id;
    private $id_object_offered;
    private $id_object_requested;
    private $id_user_offered;
    private $id_user_requested;
    private $id_status;

    /* Champs provenant de la vue */
    private $status;
    private $offered_obj_name;
    private $requested_obj_name;
    private $offered_username;
    private $requested_username;

    public function __construct(
        $id = null,
        $id_object_offered = null,
        $id_object_requested = null,
        $id_user_offered = null,
        $id_user_requested = null,
        $id_status = null,
        $status = null,
        $offered_obj_name = null,
        $requested_obj_name = null,
        $offered_username = null,
        $requested_username = null
    ) {
        $this->id = $id;
        $this->id_object_offered = $id_object_offered;
        $this->id_object_requested = $id_object_requested;
        $this->id_user_offered = $id_user_offered;
        $this->id_user_requested = $id_user_requested;
        $this->id_status = $id_status;
        $this->status = $status;
        $this->offered_obj_name = $offered_obj_name;
        $this->requested_obj_name = $requested_obj_name;
        $this->offered_username = $offered_username;
        $this->requested_username = $requested_username;
    }

    /* ===================== FIND ===================== */

    public static function findAll($db): array
    {
        $sql = "SELECT * FROM v_proposition_details";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $propositions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $propositions[] = self::mapRowToObject($row);
        }
        return $propositions;
    }

    public static function findById($db, $id): ?Proposition
    {
        $sql = "SELECT * FROM v_proposition_details WHERE id = :id";
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
        $sql = "SELECT * FROM v_proposition_details 
                WHERE id_user_offered = :id_user 
                   OR id_user_requested = :id_user";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user
        ]);

        $propositions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $propositions[] = self::mapRowToObject($row);
        }
        return $propositions;
    }

    /* ===================== INSERT ===================== */

    public function insert($db): int
    {
        $sql = "INSERT INTO exch_proposition
                (id_object_offered, id_object_requested, id_user_offered, id_user_requested, id_status)
                VALUES (:id_object_offered, :id_object_requested, :id_user_offered, :id_user_requested, :id_status)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_object_offered' => $this->id_object_offered,
            ':id_object_requested' => $this->id_object_requested,
            ':id_user_offered' => $this->id_user_offered,
            ':id_user_requested' => $this->id_user_requested,
            ':id_status' => $this->id_status ?? 1
        ]);

        $this->id = $db->lastInsertId();
        return $this->id;
    }

    /* ===================== UPDATE ===================== */

    public function updateStatus($db, $id_status): bool
    {
        $sql = "UPDATE exch_proposition 
                SET id_status = :id_status
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id_status' => $id_status,
            ':id' => $this->id
        ]);
    }

    /* ===================== DELETE ===================== */

    public function delete($db): bool
    {
        $sql = "DELETE FROM exch_proposition WHERE id = :id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':id' => $this->id
        ]);
    }

    /* ===================== MAPPER ===================== */

    private static function mapRowToObject($row): Proposition
    {
        return new Proposition(
            $row['id'],
            $row['id_object_offered'],
            $row['id_object_requested'],
            $row['id_user_offered'],
            $row['id_user_requested'],
            $row['id_status'],
            $row['status'],
            $row['offered_obj_name'],
            $row['requested_obj_name'],
            $row['offered_username'],
            $row['requested_username']
        );
    }

    /* ===================== GETTERS & SETTERS ===================== */

    public function getId() { return $this->id; }

    public function getIdObjectOffered() { return $this->id_object_offered; }
    public function setIdObjectOffered($id) { $this->id_object_offered = $id; }

    public function getIdObjectRequested() { return $this->id_object_requested; }
    public function setIdObjectRequested($id) { $this->id_object_requested = $id; }

    public function getIdUserOffered() { return $this->id_user_offered; }
    public function setIdUserOffered($id) { $this->id_user_offered = $id; }

    public function getIdUserRequested() { return $this->id_user_requested; }
    public function setIdUserRequested($id) { $this->id_user_requested = $id; }

    public function getStatus() { return $this->status; }

    public function getOfferedObjName() { return $this->offered_obj_name; }
    public function getRequestedObjName() { return $this->requested_obj_name; }

    public function getOfferedUsername() { return $this->offered_username; }
    public function getRequestedUsername() { return $this->requested_username; }
}
