<?php

namespace App\Gateway;

use PDO;

class BasicTableGateway
{
    protected PDO $connection;
    protected string $table;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=mysql;dbname=boxkampf_management", "root", "test05");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Holt alle Einträge aus der Tabelle.
     */
    public function all(): array
    {
        $sql = "SELECT * FROM $this->table";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fügt einen neuen Eintrag in die Tabelle ein.
     */
    public function insert(array $data): int
    {
        $columns = implode(",", array_keys($data));
        $placeholders = implode(",", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $statement = $this->connection->prepare($sql);
        $statement->execute(array_values($data));
        return (int)$this->connection->lastInsertId();
    }

    /**
     * Aktualisiert einen bestehenden Eintrag.
     */
    public function update(int $id, array $data): void
    {
        $set = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
        $sql = "UPDATE $this->table SET $set WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([...array_values($data), $id]);
    }
}
