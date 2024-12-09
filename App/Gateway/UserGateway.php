<?php

namespace App\Gateway;

class UserGateway extends BasicTableGateway
{
    protected string $table = "users"; // Name der Tabelle "users"

    /**
     * Findet einen Benutzer anhand der ID.
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        // SQL-Abfrage, um einen Benutzer anhand der ID zu finden
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        // Gibt das Ergebnis als Array zurück oder null, wenn kein Benutzer gefunden wird
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Findet einen Benutzer anhand des Benutzernamens.
     *
     * @param string $username
     * @return array|null
     */
    public function findByUsername(string $username): ?array
    {
        // SQL-Abfrage, um einen Benutzer anhand des Benutzernamens zu finden
        $sql = "SELECT * FROM $this->table WHERE username = :username";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->execute();

        // Gibt das Ergebnis als Array zurück oder null, wenn kein Benutzer gefunden wird
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Fügt einen neuen Benutzer hinzu.
     *
     * @param array $data
     * @return int
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
     *
     * @param int $id
     * @param array $data
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
     *
     * @param int $id
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
