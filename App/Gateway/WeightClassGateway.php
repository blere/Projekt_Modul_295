<?php

namespace App\Gateway;

class WeightClassGateway extends BasicTableGateway
{
    protected string $table = "weight_classes"; // Name der Tabelle

    /**
     * Holt alle Gewichtsklassen.
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
     * Findet eine Gewichtsklasse anhand der ID.
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
     * Löscht eine Gewichtsklasse anhand der ID.
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
