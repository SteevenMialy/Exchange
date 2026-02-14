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
    private $date_proposal;
    private $status;

    /* Objets liés */
    public $objectOffered;
    public $objectRequested;

    public function __construct(
        $id = null,
        $id_object_offered = null,
        $id_object_requested = null,
        $id_user_offered = null,
        $id_user_requested = null,
        $id_status = null,
        $date_proposal = null,
        $status = null
    ) {
        $this->id = $id;
        $this->id_object_offered = $id_object_offered;
        $this->id_object_requested = $id_object_requested;
        $this->id_user_offered = $id_user_offered;
        $this->id_user_requested = $id_user_requested;
        $this->id_status = $id_status;
        $this->date_proposal = $date_proposal;
        $this->status = $status;
    }

    public function exchangeOwners($db): bool
    {
        try {
            $db->beginTransaction();

            // Échanger les propriétaires des objets
            $sql = "UPDATE exch_object 
                    SET id_user = CASE 
                        WHEN id = :id_object_offered THEN :id_user_requested
                        WHEN id = :id_object_requested THEN :id_user_offered
                    END
                    WHERE id IN (:id_object_offered, :id_object_requested)";

            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                ':id_object_offered' => $this->id_object_offered,
                ':id_object_requested' => $this->id_object_requested,
                ':id_user_offered' => $this->id_user_offered,
                ':id_user_requested' => $this->id_user_requested
            ]);

            $db->commit();
            return $result;
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /* ===================== FIND ===================== */

    public static function findAll($db): array
    {
        $sql = "SELECT * FROM v_proposition_details";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $propositions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prop = self::mapRowToObject($row);
            $prop->objectOffered = ExchObject::findById($db, $row['id_object_offered']);
            $prop->objectRequested = ExchObject::findById($db, $row['id_object_requested']);
            $propositions[] = $prop;
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
            $prop = self::mapRowToObject($row);
            $prop->objectOffered = ExchObject::findById($db, $row['id_object_offered']);
            $prop->objectRequested = ExchObject::findById($db, $row['id_object_requested']);
            return $prop;
        }
        return null;
    }

    public static function findProposalSent($db, $id_user): array
    {
        $sql = "SELECT * FROM v_proposition_details 
                WHERE id_user_requested = :id_user
                AND id_status = 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user
        ]);

        $propositions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prop = self::mapRowToObject($row);
            $prop->objectOffered = ExchObject::findById($db, $row['id_object_offered']);
            $prop->objectRequested = ExchObject::findById($db, $row['id_object_requested']);
            $propositions[] = $prop;
        }
        return $propositions;
    }

    public static function countProposalSent($db, $id_user): int
    {
        $sql = "SELECT COUNT(*) as count FROM v_proposition_details 
                WHERE id_user_requested = :id_user 
                AND id_status = 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user
        ]);

        $count = 0;
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $count = $row['count'];
        }
        return $count;
    }

    public static function findProposalReceived($db, $id_user): array
    {
        $sql = "SELECT * FROM v_proposition_details 
                WHERE id_user_offered = :id_user 
                AND id_status = 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user
        ]);

        $propositions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prop = self::mapRowToObject($row);
            $prop->objectOffered = ExchObject::findById($db, $row['id_object_offered']);
            $prop->objectRequested = ExchObject::findById($db, $row['id_object_requested']);
            $propositions[] = $prop;
        }
        return $propositions;
    }

    public static function countProposalReceived($db, $id_user): int
    {
        $sql = "SELECT COUNT(*) as count FROM v_proposition_details 
                WHERE id_user_offered = :id_user 
                AND id_status = 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user
        ]);

        $count = 0;
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $count = $row['count'];
        }
        return $count;
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
            $prop = self::mapRowToObject($row);
            $prop->objectOffered = ExchObject::findById($db, $row['id_object_offered']);
            $prop->objectRequested = ExchObject::findById($db, $row['id_object_requested']);
            $propositions[] = $prop;
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
            $row['date_proposal'],
            $row['status']
        );
    }

    /* ===================== GETTERS & SETTERS ===================== */

    public function getId() { return $this->id; }

    public function getIdObjectOffered() { return $this->id_object_offered; }
    public function setIdObjectOffered($id) { $this->id_object_offered = $id; }

    public function getObjectOffered() { return $this->objectOffered; }
    public function setObjectOffered($object) { $this->objectOffered = $object; }

    public function getObjectRequested() { return $this->objectRequested; }
    public function setObjectRequested($object) { $this->objectRequested = $object; }

    public function getIdObjectRequested() { return $this->id_object_requested; }
    public function setIdObjectRequested($id) { $this->id_object_requested = $id; }

    public function getIdUserOffered() { return $this->id_user_offered; }
    public function setIdUserOffered($id) { $this->id_user_offered = $id; }

    public function getIdUserRequested() { return $this->id_user_requested; }
    public function setIdUserRequested($id) { $this->id_user_requested = $id; }

    public function getDateProposal() { return $this->date_proposal; }

    public function getStatus() { return $this->status; }
}
