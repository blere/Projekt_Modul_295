<?php

namespace App\Gateway;

class FighterGateway extends BasicTableGateway
{
    protected string $table = "fighters";

    // Alle Kämpfer abrufen
    public function all(): array
    {
        $sql = "
            SELECT 
                f.id, 
                f.full_name, 
                f.fighter_name, 
                f.birthdate, 
                f.height, 
                f.weight, 
                f.experience_level,
                COALESCE(c.name, 'Unbekannt') AS city_name, 
                COALESCE(wc.class_name, 'Unbekannt') AS weight_class_name
            FROM fighters f
            LEFT JOIN cities c ON f.city_id = c.id
            LEFT JOIN weight_classes wc ON f.weight_class_id = wc.id
        ";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Kämpfer anhand ID finden
    public function find(int $id): ?array
    {
        $sql = "
            SELECT 
                f.id, 
                f.full_name, 
                f.fighter_name, 
                f.birthdate, 
                f.height, 
                f.weight, 
                f.experience_level,
                COALESCE(c.name, 'Unbekannt') AS city_name, 
                COALESCE(wc.class_name, 'Unbekannt') AS weight_class_name
            FROM fighters f
            LEFT JOIN cities c ON f.city_id = c.id
            LEFT JOIN weight_classes wc ON f.weight_class_id = wc.id
            WHERE f.id = :id
        ";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    // Kämpfer aktualisieren
    public function update(int $id, array $data): void
    {
        $sql = "
            UPDATE fighters 
            SET 
                full_name = :full_name, 
                fighter_name = :fighter_name, 
                birthdate = :birthdate, 
                height = :height, 
                weight = :weight, 
                weight_class_id = :weight_class_id, 
                city_id = :city_id, 
                experience_level = :experience_level
            WHERE id = :id
        ";
        $statement = $this->connection->prepare($sql);
        $statement->execute(array_merge($data, ['id' => $id]));
    }

    // Kämpfer löschen
    public function delete(int $id): void
    {
        $sql = "DELETE FROM fighters WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }
}
