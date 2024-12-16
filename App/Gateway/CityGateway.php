<?php

namespace App\Gateway;

class CityGateway extends BasicTableGateway
{
    // Definiert den Namen der Tabelle
    protected string $table = "cities";

    /**
     * Findet eine Stadt anhand der ID.
     * @param int $id Die ID der Stadt
     * @return array|null Gibt die Stadt als Array zurück oder null, falls nicht gefunden
     */
    public function find(int $id): ?array
    {
        // SQL-Abfrage, um eine Stadt anhand der ID zu finden
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT); // Bindet die ID an die Abfrage
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_ASSOC); // Holt das Ergebnis als assoziatives Array
        return $result ?: null; // Gibt null zurück, wenn keine Stadt gefunden wurde
    }

    /**
     * Löscht eine Stadt anhand der ID.
     * @param int $id Die ID der Stadt
     * @return void
     */
    public function delete(int $id): void
    {
        // SQL-Abfrage, um eine Stadt anhand der ID zu löschen
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT); // Bindet die ID an die Abfrage
        $statement->execute(); // Führt die Abfrage aus
    }
}

/**
 * Beschreibung des Codes:
 * 
 * - `CityGateway` ist eine Klasse, die Datenbankoperationen für die Tabelle `cities` kapselt.
 * - Eigenschaften:
 *   - `table`: Gibt an, auf welche Tabelle die Klasse zugreift.
 * - Methoden:
 *   - `find`: Sucht eine Stadt anhand ihrer ID und gibt sie als assoziatives Array zurück. Gibt `null` zurück, wenn keine Stadt gefunden wurde.
 *   - `delete`: Löscht eine Stadt anhand ihrer ID aus der Tabelle.
 * - Die Klasse erbt von `BasicTableGateway` und nutzt die darin definierten Verbindungseigenschaften.
 */
