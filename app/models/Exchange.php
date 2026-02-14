<?php

namespace app\models;

use PDO;

class Exchange
{
    public $id;
    private $date_exchange;

    /* Objet lié */
    public $proposition;

    public function __construct(
        $id = null,
        $date_exchange = null
    ) {
        $this->id = $id;
        $this->date_exchange = $date_exchange;
    }

    /* ===================== FIND ===================== */

    public static function findAll($db): array
    {
        $sql = "SELECT * FROM exch_exchange_history ORDER BY date_exchange DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $history = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $exchange = self::mapRowToObject($row);
            $exchange->proposition = Proposition::findById($db, $row['id_proposition']);
            $history[] = $exchange;
        }
        return $history;
    }

    public static function findById($db, $id)
    {
        $sql = "SELECT * FROM exch_exchange_history WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $exchange = self::mapRowToObject($row);
            $exchange->proposition = Proposition::findById($db, $row['id_proposition']);
            return $exchange;
        }
        return null;
    }

    public static function findByUser($db, $id_user): array
    {
        $sql = "SELECT eh.* FROM exch_exchange_history eh
                JOIN exch_proposition p ON eh.id_proposition = p.id
                WHERE p.id_user_offered = :id_user
                OR p.id_user_requested = :id_user
                ORDER BY eh.date_exchange DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user
        ]);

        $history = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $exchange = self::mapRowToObject($row);
            $exchange->proposition = Proposition::findById($db, $row['id_proposition']);
            $history[] = $exchange;
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
            ':id_proposition' => $this->proposition->id
        ]);

        $this->id = $db->lastInsertId();
        return $this->id;
    }

    /* ===================== MAPPER ===================== */

    private static function mapRowToObject($row): Exchange{
        return new Exchange(
            $row['id'],
            $row['date_exchange']
        );
    }

    /* ===================== GETTERS ===================== */

    public function getId() { return $this->id; }

    public function getProposition() { return $this->proposition; }
    public function setProposition($proposition) { $this->proposition = $proposition; }

    public function getDateExchange() { return $this->date_exchange; }
}
