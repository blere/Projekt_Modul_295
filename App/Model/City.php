<?php

namespace App\Model;

use App\Gateway\CityGateway;

class City
{
    private int $id; // ID der Stadt
    private string $name; // Name der Stadt

    // Getter und Setter für ID
    public function getid(): int { return $this->id; } // Getter für ID
    public function setid(int $id): void { $this->id = $id; } // Setter für ID

    // Getter und Setter für Name
    public function getname(): string { return $this->name; } // Getter für Name
    public function setname(string $name): void { $this->name = $name; } // Setter für Name

    /**
     * Ruft alle Städte aus der Datenbank ab.
     * @return array Eine Liste aller Städte
     */
    public static function all(): array
    {
        $gateway = new CityGateway(); // Gateway-Instanz erstellen
        return $gateway->all(); // Abruf aller Städte aus der Datenbank
    }

    /**
     * Findet eine Stadt anhand der ID.
     * @param int $id Die ID der Stadt
     * @return self|null Gibt eine Stadt zurück oder null, wenn sie nicht gefunden wurde
     */
    public static function find(int $id): ?self
    {
        $gateway = new CityGateway(); // Gateway-Instanz erstellen
        $data = $gateway->find($id); // Daten aus der Datenbank abrufen
        return $data ? self::create($data) : null; // Stadt erstellen oder null zurückgeben
    }

    // Speichert die Stadt (neu oder aktualisiert).
    public function save(): void
    {
        $gateway = new CityGateway(); // Gateway-Instanz erstellen
        if (isset($this->id)) {
            // Aktualisiert die Stadt, wenn die ID existiert
            $gateway->update($this->id, ['name' => $this->name]);
        } else {
            // Fügt eine neue Stadt hinzu und speichert die ID
            $this->id = $gateway->insert(['name' => $this->name]);
        }
    }

    /**
     * Löscht die Stadt.
     * @throws \Exception Wenn die Stadt-ID nicht gesetzt ist
     */
    public function delete(): void
    {
        if (!isset($this->id)) {
            throw new \Exception("Kann keine Stadt löschen, die nicht existiert.");
        }

        $gateway = new CityGateway(); // Gateway-Instanz erstellen
        $gateway->delete($this->id); // Stadt aus der Datenbank löschen
    }

    /**
     * Erstellt eine Instanz aus den Datenbankinformationen.
     * @param array $data Die Daten der Stadt aus der Datenbank
     * @return self Eine neue Instanz der Stadt
     */
    private static function create(array $data): self
    {
        $city = new self(); // Neue Stadt-Instanz erstellen
        $city->setid($data['id']); // ID setzen
        $city->setname($data['name']); // Name setzen
        return $city; // Instanz zurückgeben
    }
}

/**
 * Beschreibung des Codes:
 *
 * - Diese Klasse repräsentiert eine Stadt in der Anwendung.
 * - Eigenschaften:
 *   - `id`: Eindeutige Identifikationsnummer der Stadt
 *   - `name`: Name der Stadt
 * - CRUD-Methoden:
 *   - `all`: Holt alle Städte aus der Datenbank.
 *   - `find`: Findet eine Stadt anhand ihrer ID.
 *   - `save`: Speichert eine Stadt (Insert oder Update).
 *   - `delete`: Löscht eine Stadt aus der Datenbank.
 * - Unterstützt das Erstellen von Stadt-Instanzen aus Datenbankeinträgen.
 */
