<?php

namespace App\Gateway;

class ArenaGateway extends BasicTableGateway
{
    protected string $table = "arenas"; // Tabellenname

    public function all(): array
    {
        $sql = "
            SELECT 
                a.id,
                a.name,
                a.city_id,
                a.weight_class_id,
                c.name AS city_name,
                wc.class_name AS weight_class_name
            FROM arenas a
            LEFT JOIN cities c ON a.city_id = c.id
            LEFT JOIN weight_classes wc ON a.weight_class_id = wc.id
        ";
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "
            SELECT 
                a.id,
                a.name,
                a.city_id,
                a.weight_class_id
            FROM arenas a
            WHERE a.id = :id
        ";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Löscht eine Arena anhand ihrer ID.
     *
     * @param int $id Die ID der zu löschenden Arena
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
