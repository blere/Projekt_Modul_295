<?php

namespace App\Gateway;

class FighterGateway extends BasicTableGateway
{
    // Name der Tabelle
    protected string $table = "fighters";

    /**
     * Holt alle Kämpfer aus der Datenbank.
     * @return array Gibt eine Liste von Kämpfern zurück, einschließlich Stadt- und Gewichtsklasseninformationen.
     */
    public function all(): array
    {
        // SQL-Abfrage, um alle Kämpfer mit zugehörigen Städten und Gewichtsklassen zu holen
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
        return $statement->fetchAll(\PDO::FETCH_ASSOC); // Gibt alle Einträge als Array zurück
    }

    /**
     * Findet einen Kämpfer anhand seiner ID.
     * @param int $id Die ID des Kämpfers.
     * @return array|null Gibt die Kämpferdaten zurück oder null, falls nicht gefunden.
     */
    public function find(int $id): ?array
    {
        // SQL-Abfrage, um einen Kämpfer anhand der ID zu finden
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
        $statement->bindParam(':id', $id, \PDO::PARAM_INT); // Bindet die ID an die Abfrage
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC) ?: null; // Gibt null zurück, wenn kein Kämpfer gefunden wurde
    }

    /**
     * Aktualisiert die Daten eines Kämpfers.
     * @param int $id Die ID des zu aktualisierenden Kämpfers.
     * @param array $data Die neuen Daten des Kämpfers.
     */
    public function update(int $id, array $data): void
    {
        // SQL-Abfrage, um die Daten eines Kämpfers zu aktualisieren
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
        $statement->execute(array_merge($data, ['id' => $id])); // Führt die Abfrage mit den neuen Daten aus
    }

    /**
     * Löscht einen Kämpfer anhand seiner ID.
     * @param int $id Die ID des zu löschenden Kämpfers.
     */
    public function delete(int $id): void
    {
        // SQL-Abfrage, um einen Kämpfer zu löschen
        $sql = "DELETE FROM fighters WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]); // Bindet die ID und führt die Abfrage aus
    }
}

/**
 * Beschreibung des Codes:
 * 
 * - `FighterGateway` ist eine Klasse, die für Datenbankoperationen der Tabelle `fighters` zuständig ist.
 * - Funktionen:
 *   - `all`: Holt alle Kämpfer einschließlich der zugehörigen Stadt- und Gewichtsklasseninformationen.
 *   - `find`: Findet einen spezifischen Kämpfer anhand seiner ID.
 *   - `update`: Aktualisiert die Daten eines Kämpfers in der Tabelle.
 *   - `delete`: Löscht einen Kämpfer anhand seiner ID.
 * - Diese Klasse ermöglicht die Interaktion mit der Tabelle `fighters` und enthält notwendige Methoden für CRUD-Operationen.
 */
