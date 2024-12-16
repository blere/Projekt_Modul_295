<?php

namespace App\Gateway;

use PDO;

class BasicTableGateway
{
    // Datenbankverbindung und Tabellenname
    protected PDO $connection; 
    protected string $table; 

    //Konstruktor: Stellt die Verbindung zur MySQL-Datenbank her und aktiviert den Fehler-Modus.
    public function __construct()
    {
        $this->connection = new PDO("mysql:host=mysql;dbname=boxkampf_management", "root", "test05");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Holt alle Einträge aus der Tabelle.
    public function all(): array
    {
        // SQL-Anweisung, um alle Datensätze aus der Tabelle abzurufen
        $sql = "SELECT * FROM $this->table";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); // Gibt die Ergebnisse als Array zurück
    }

    //Fügt einen neuen Eintrag in die Tabelle ein.
    public function insert(array $data): int
    {
        // Erstellt dynamisch die SQL-INSERT-Anweisung mit Platzhaltern
        $columns = implode(",", array_keys($data));
        $placeholders = implode(",", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $statement = $this->connection->prepare($sql);
        $statement->execute(array_values($data)); // Führt die Abfrage mit den übergebenen Werten aus
        return (int)$this->connection->lastInsertId(); // Gibt die ID des eingefügten Eintrags zurück
    }

    //Aktualisiert einen bestehenden Eintrag.
    public function update(int $id, array $data): void
    {
        // Erstellt dynamisch die SQL-UPDATE-Anweisung für die Spalten
        $set = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
        $sql = "UPDATE $this->table SET $set WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([...array_values($data), $id]); // Führt die Abfrage aus und bindet die Werte
    }
}

/**
 * Beschreibung des Codes:
 * 
 * - `BasicTableGateway` ist eine abstrakte Klasse, die allgemeine Datenbankoperationen bereitstellt.
 * - Konstruktor:
 *   - Baut die Verbindung zur MySQL-Datenbank auf und aktiviert den Fehler-Modus, um Ausnahmen bei Fehlern zu werfen.
 * - Methoden:
 *   - `all`: Führt einen SELECT *-Befehl aus, um alle Datensätze aus der Tabelle zu laden.
 *   - `insert`: Fügt einen neuen Datensatz in die Tabelle ein, indem dynamisch Platzhalter und Werte zugeordnet werden.
 *   - `update`: Aktualisiert einen bestehenden Datensatz anhand der ID mit den übergebenen neuen Werten.
 */
