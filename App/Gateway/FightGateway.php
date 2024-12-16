<?php

namespace App\Gateway;

class FightGateway extends BasicTableGateway
{
    // Name der Tabelle
    protected string $table = "fights";

    /**
     * Holt alle Kämpfe mit verbundenen Daten (Kämpfer und Arena).
     * @return array Gibt eine Liste aller Kämpfe mit erweiterten Informationen zurück.
     */
    public function all(): array
    {
        // SQL-Abfrage, um alle Kämpfe und deren Beziehungen zu Kämpfern und Arenen abzurufen
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

        // Gibt alle Kämpfe als Array zurück
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Findet einen Kampf anhand seiner ID.
     * @param int $id Die ID des Kampfes.
     * @return array|null Gibt die Kampfdaten oder null zurück, wenn der Kampf nicht gefunden wurde.
     */
    public function find(int $id): ?array
    {
        // SQL-Abfrage, um einen Kampf anhand seiner ID abzurufen
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
        $statement->bindParam(':id', $id, \PDO::PARAM_INT); // Bindet die ID an die Abfrage
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null; // Gibt null zurück, wenn kein Eintrag gefunden wurde
    }

    /**
     * Fügt einen neuen Kampf in die Datenbank ein.
     * @param array $data Die Daten des neuen Kampfes.
     * @return int Gibt die ID des neu eingefügten Kampfes zurück.
     */
    public function insert(array $data): int
    {
        // SQL-Abfrage, um einen neuen Kampf einzufügen
        $sql = "
            INSERT INTO fights (fighter1_id, fighter2_id, arena_id, date, contact_type, result)
            VALUES (:fighter1_id, :fighter2_id, :arena_id, :date, :contact_type, :result)
        ";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);

        // Gibt die ID des eingefügten Eintrags zurück
        return (int)$this->connection->lastInsertId();
    }

    /**
     * Aktualisiert einen bestehenden Kampf.
     * @param int $id Die ID des Kampfes.
     * @param array $data Die neuen Daten des Kampfes.
     */
    public function update(int $id, array $data): void
    {
        // SQL-Abfrage, um einen bestehenden Kampf zu aktualisieren
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
        $data['id'] = $id; // Fügt die ID zu den Daten hinzu
        $statement->execute($data); // Führt die Abfrage aus
    }

    /**
     * Löscht einen Kampf aus der Datenbank.
     * @param int $id Die ID des Kampfes.
     */
    public function delete(int $id): void
    {
        // SQL-Abfrage, um einen Kampf zu löschen
        $sql = "DELETE FROM fights WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT); // Bindet die ID an die Abfrage
        $statement->execute(); // Führt die Abfrage aus
    }
}

/**
 * Beschreibung des Codes:
 *
 * - `FightGateway` verwaltet Datenbankoperationen für die Tabelle `fights`.
 * - Funktionen:
 *   - `all`: Holt alle Kämpfe mit zugehörigen Kämpfern und Arenen.
 *   - `find`: Findet einen spezifischen Kampf anhand seiner ID.
 *   - `insert`: Fügt einen neuen Kampf in die Tabelle ein.
 *   - `update`: Aktualisiert die Daten eines bestehenden Kampfes.
 *   - `delete`: Löscht einen Kampf anhand seiner ID.
 * - Diese Klasse implementiert die CRUD-Operationen (Create, Read, Update, Delete) für Kämpfe.
 */
