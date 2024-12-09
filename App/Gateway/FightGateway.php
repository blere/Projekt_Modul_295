<?php

namespace App\Gateway;

class FightGateway extends BasicTableGateway
{
    protected string $table = "fights"; // Name der Tabelle

    /**
     * Holt alle Kämpfe mit verbundenen Daten (Kämpfer, Arena).
     *
     * @return array
     */
    public function all(): array
    {
        $sql = "
            SELECT 
                f.id, 
                f.fighter1_id, 
                f.fighter2_id, 
                f.arena_id, 
                f.date, 
                f.contact_type, 
                f.result,
                f1.fighter_name AS fighter1_name,
                f2.fighter_name AS fighter2_name,
                a.name AS arena_name
            FROM fights f
            LEFT JOIN fighters f1 ON f.fighter1_id = f1.id
            LEFT JOIN fighters f2 ON f.fighter2_id = f2.id
            LEFT JOIN arenas a ON f.arena_id = a.id
        ";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Findet einen Kampf anhand der ID.
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        $sql = "
            SELECT 
                f.id, 
                f.fighter1_id, 
                f.fighter2_id, 
                f.arena_id, 
                f.date, 
                f.contact_type, 
                f.result,
                f1.fighter_name AS fighter1_name,
                f2.fighter_name AS fighter2_name,
                a.name AS arena_name
            FROM fights f
            LEFT JOIN fighters f1 ON f.fighter1_id = f1.id
            LEFT JOIN fighters f2 ON f.fighter2_id = f2.id
            LEFT JOIN arenas a ON f.arena_id = a.id
            WHERE f.id = :id
        ";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Fügt einen neuen Kampf in die Datenbank ein.
     *
     * @param array $data
     * @return int Die ID des eingefügten Kampfes
     */
    public function insert(array $data): int
    {
        $sql = "
            INSERT INTO fights (fighter1_id, fighter2_id, arena_id, date, contact_type, result)
            VALUES (:fighter1_id, :fighter2_id, :arena_id, :date, :contact_type, :result)
        ";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Aktualisiert einen bestehenden Kampf.
     *
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data): void
    {
        $sql = "
            UPDATE fights
            SET fighter1_id = :fighter1_id,
                fighter2_id = :fighter2_id,
                arena_id = :arena_id,
                date = :date,
                contact_type = :contact_type,
                result = :result
            WHERE id = :id
        ";

        $statement = $this->connection->prepare($sql);
        $data['id'] = $id;
        $statement->execute($data);
    }

    /**
     * Löscht einen Kampf anhand der ID.
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM fights WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
