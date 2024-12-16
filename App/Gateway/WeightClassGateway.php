<?php

namespace App\Gateway;

class WeightClassGateway extends BasicTableGateway
{
    // Name der Tabelle
    protected string $table = "weight_classes";

    /**
     * Holt alle Gewichtsklassen.
     * @return array Gibt ein Array aller Gewichtsklassen zurück.
     */
    public function all(): array
    {
        // SQL-Abfrage, um alle Gewichtsklassen abzurufen
        $sql = "SELECT * FROM $this->table";
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        // Gibt die Gewichtsklassen als Array zurück
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Findet eine Gewichtsklasse anhand der ID.
     * @param int $id Die ID der Gewichtsklasse.
     * @return array|null Gibt die Gewichtsklasse als Array zurück oder null, wenn keine gefunden wurde.
     */
    public function find(int $id): ?array
    {
        // SQL-Abfrage, um eine Gewichtsklasse anhand der ID zu finden
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        // Gibt die Gewichtsklasse zurück oder null, wenn keine gefunden wurde
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Löscht eine Gewichtsklasse anhand der ID.
     * @param int $id Die ID der Gewichtsklasse.
     * @return void
     */
    public function delete(int $id): void
    {
        // SQL-Abfrage, um eine Gewichtsklasse anhand der ID zu löschen
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}

/**
 * Beschreibung des Codes:
 *
 * - `WeightClassGateway` verwaltet Datenbankoperationen für die Tabelle `weight_classes`.
 * - Funktionen:
 *   - `all`: Ruft alle Gewichtsklassen aus der Tabelle ab.
 *   - `find`: Sucht eine bestimmte Gewichtsklasse anhand der ID.
 *   - `delete`: Löscht eine Gewichtsklasse anhand der ID.
 * - Diese Klasse bietet grundlegende CRUD-Funktionalitäten (Read und Delete) für Gewichtsklassen.
 */
