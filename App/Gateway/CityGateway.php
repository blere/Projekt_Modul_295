<?php

namespace App\Gateway;

class CityGateway extends BasicTableGateway
{
    protected string $table = "cities"; // Name der Tabelle

    /**
     * Holt alle Städte.
     *
     * @return array
     */
    public function all(): array
    {
        $sql = "SELECT * FROM $this->table";
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Findet eine Stadt anhand der ID.
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Löscht eine Stadt anhand der ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
