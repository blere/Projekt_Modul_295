<?php

namespace App\Gateway;

class UserGateway extends BasicTableGateway
{
    // Name der Tabelle "users"
    protected string $table = "users";

    /**
     * Findet einen Benutzer anhand der ID.
     * @param int $id Die ID des Benutzers.
     * @return array|null Gibt die Benutzerdaten zurück oder null, wenn kein Benutzer gefunden wurde.
     */
    public function find(int $id): ?array
    {
        // SQL-Abfrage, um einen Benutzer anhand der ID zu finden
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        // Gibt das Ergebnis als Array zurück oder null, wenn kein Benutzer gefunden wurde
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Findet einen Benutzer anhand des Benutzernamens.
     * @param string $username Der Benutzername.
     * @return array|null Gibt die Benutzerdaten zurück oder null, wenn kein Benutzer gefunden wurde.
     */
    public function findByUsername(string $username): ?array
    {
        // SQL-Abfrage, um einen Benutzer anhand des Benutzernamens zu finden
        $sql = "SELECT * FROM $this->table WHERE username = :username";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->execute();

        // Gibt das Ergebnis als Array zurück oder null, wenn kein Benutzer gefunden wurde
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Fügt einen neuen Benutzer hinzu.
     * @param array $data Die Benutzerdaten.
     * @return int Gibt die ID des neu erstellten Benutzers zurück.
     */
    public function insert(array $data): int
    {
        // SQL-Abfrage, um einen neuen Benutzer einzufügen
        $sql = "INSERT INTO $this->table (firstname, lastname, email, username, password_hash) 
                VALUES (:firstname, :lastname, :email, :username, :password_hash)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':firstname', $data['firstname']);
        $statement->bindParam(':lastname', $data['lastname']);
        $statement->bindParam(':email', $data['email']);
        $statement->bindParam(':username', $data['username']);
        $statement->bindParam(':password_hash', $data['password_hash']);
        $statement->execute();

        // Gibt die ID des neu erstellten Benutzers zurück
        return (int)$this->connection->lastInsertId();
    }

    /**
     * Aktualisiert einen bestehenden Benutzer.
     * @param int $id Die ID des Benutzers.
     * @param array $data Die neuen Benutzerdaten.
     * @return void
     */
    public function update(int $id, array $data): void
    {
        // SQL-Abfrage, um einen bestehenden Benutzer zu aktualisieren
        $sql = "UPDATE $this->table 
                SET firstname = :firstname, lastname = :lastname, email = :email, 
                    username = :username, password_hash = :password_hash 
                WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':firstname', $data['firstname']);
        $statement->bindParam(':lastname', $data['lastname']);
        $statement->bindParam(':email', $data['email']);
        $statement->bindParam(':username', $data['username']);
        $statement->bindParam(':password_hash', $data['password_hash']);
        $statement->execute();
    }

    /**
     * Löscht einen Benutzer anhand der ID.
     * @param int $id Die ID des Benutzers.
     * @return void
     */
    public function delete(int $id): void
    {
        // SQL-Abfrage, um einen Benutzer anhand der ID zu löschen
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}

/**
 * Beschreibung des Codes:
 *
 * - `UserGateway` verwaltet Datenbankoperationen für die Tabelle `users`.
 * - Funktionen:
 *   - `find`: Sucht einen Benutzer anhand der ID.
 *   - `findByUsername`: Sucht einen Benutzer anhand des Benutzernamens.
 *   - `insert`: Fügt einen neuen Benutzer in die Datenbank ein.
 *   - `update`: Aktualisiert die Daten eines bestehenden Benutzers.
 *   - `delete`: Löscht einen Benutzer anhand der ID.
 * - Diese Klasse implementiert die grundlegenden CRUD-Operationen (Create, Read, Update, Delete) für Benutzer.
 */
