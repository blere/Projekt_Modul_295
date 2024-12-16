<?php

namespace App\Model;

use App\Gateway\WeightClassGateway;

// Die WeightClass-Klasse repräsentiert eine Gewichtsklasse im System.
class WeightClass
{
    private int $id; // ID der Gewichtsklasse
    private string $class_name; // Name der Gewichtsklasse

    // Getter und Setter für ID
    public function getid(): int { return $this->id; } // Gibt die ID der Gewichtsklasse zurück
    public function setid(int $id): void { $this->id = $id; } // Setzt die ID der Gewichtsklasse

    // Getter und Setter für den Namen der Gewichtsklasse
    public function getclass_name(): string { return $this->class_name; } // Gibt den Namen der Gewichtsklasse zurück
    public function setclass_name(string $class_name): void { $this->class_name = $class_name; } // Setzt den Namen der Gewichtsklasse

    /**
     * Ruft alle Gewichtsklassen aus der Datenbank ab.
     * @return array Liste von Gewichtsklassen
     */
    public static function all(): array
    {
        $gateway = new WeightClassGateway(); // Gateway-Instanz
        return array_map(fn($data) => self::create($data), $gateway->all()); // Gewichtsklassen als Objekte erstellen
    }

    /**
     * Findet eine Gewichtsklasse anhand der ID.
     * @param int $id Die ID der Gewichtsklasse
     * @return self|null Gibt die Gewichtsklasse zurück oder null, falls nicht gefunden
     */
    public static function find(int $id): ?self
    {
        $gateway = new WeightClassGateway(); // Gateway-Instanz
        $data = $gateway->find($id); // Daten abrufen
        return $data ? self::create($data) : null; // Gewichtsklasse erstellen, wenn Daten vorhanden
    }

    //Speichert die Gewichtsklasse (neu oder aktualisiert).
    public function save(): void
    {
        $gateway = new WeightClassGateway(); // Gateway-Instanz
        if (isset($this->id)) {
            $gateway->update($this->id, ['class_name' => $this->class_name]); // Gewichtsklasse aktualisieren
        } else {
            $this->id = $gateway->insert(['class_name' => $this->class_name]); // Neue Gewichtsklasse einfügen
        }
    }

    // Löscht die Gewichtsklasse.
    public function delete(): void
    {
        if (!isset($this->id)) {
            throw new \Exception("Kann keine Gewichtsklasse löschen, die nicht existiert."); // Fehler werfen, wenn ID nicht gesetzt
        }

        $gateway = new WeightClassGateway(); // Gateway-Instanz
        $gateway->delete($this->id); // Gewichtsklasse löschen
    }

    /**
     * Erstellt eine Instanz aus den Datenbankinformationen.
     * @param array $data Array mit Daten aus der Datenbank
     * @return self Gewichtsklasse-Instanz
     */
    private static function create(array $data): self
    {
        $weightClass = new self();
        $weightClass->setid($data['id']); // ID setzen
        $weightClass->setclass_name($data['class_name']); // Name setzen
        return $weightClass; // Gewichtsklasse-Objekt zurückgeben
    }
}

/**
 * Beschreibung des Codes:
 *
 * - Die `WeightClass`-Klasse repräsentiert die Gewichtsklassen.
 * - Eigenschaften:
 *   - `id`: Die eindeutige ID der Gewichtsklasse.
 *   - `class_name`: Der Name der Gewichtsklasse.
 * - Methoden:
 *   - `all`: Ruft alle Gewichtsklassen aus der Datenbank ab.
 *   - `find`: Sucht eine Gewichtsklasse anhand ihrer ID.
 *   - `save`: Speichert die Gewichtsklasse (neu oder aktualisiert).
 *   - `delete`: Löscht eine Gewichtsklasse.
 *   - `create`: Erstellt eine `WeightClass`-Instanz aus den Datenbankdaten.
 * - Die Klasse interagiert über das `WeightClassGateway` mit der Datenbank.
 */
