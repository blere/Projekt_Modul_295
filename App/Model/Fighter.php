<?php

namespace App\Model;

use App\Gateway\FighterGateway;

// Die Fighter-Klasse repräsentiert einen Kämpfer im System.
class Fighter
{
    // Eigenschaften des Kämpfers (z. B. ID, Name, Gewichtsklasse, Stadt usw.).
    private int $id; // ID des Kämpfers
    private string $full_name; // Vollständiger Name
    private string $fighter_name; // Kämpfername
    private string $birthdate; // Geburtsdatum
    private int $height; // Größe
    private int $weight; // Gewicht
    private ?int $weight_class_id; // Gewichtsklassen-ID
    private ?int $city_id; // Stadt-ID
    private string $experience_level; // Erfahrungslevel (z. B. Amateur, Profi)
    private ?string $weight_class_name; // Name der Gewichtsklasse
    private ?string $city_name; // Name der Stadt

    // Getter und Setter für jede Eigenschaft (z. B. ID, Name, Gewicht usw.).
    public function getid(): int { return $this->id; }
    public function setid(int $id): void { $this->id = $id; }

    public function getfull_name(): string { return $this->full_name; }
    public function setfull_name(string $full_name): void { $this->full_name = $full_name; }

    public function getfighter_name(): string { return $this->fighter_name; }
    public function setfighter_name(string $fighter_name): void { $this->fighter_name = $fighter_name; }

    public function getbirthdate(): string { return $this->birthdate; }
    public function setbirthdate(string $birthdate): void { $this->birthdate = $birthdate; }

    public function getheight(): int { return $this->height; }
    public function setheight(int $height): void { $this->height = $height; }

    public function getweight(): int { return $this->weight; }
    public function setweight(int $weight): void { $this->weight = $weight; }

    public function getweight_class_id(): ?int { return $this->weight_class_id; }
    public function setweight_class_id(?int $weight_class_id): void { $this->weight_class_id = $weight_class_id; }

    public function getcity_id(): ?int { return $this->city_id; }
    public function setcity_id(?int $city_id): void { $this->city_id = $city_id; }

    public function getexperience_level(): string { return $this->experience_level; }
    public function setexperience_level(string $experience_level): void { $this->experience_level = $experience_level; }

    public function getweight_class_name(): ?string { return $this->weight_class_name; }
    public function setweight_class_name(?string $weight_class_name): void { $this->weight_class_name = $weight_class_name; }

    public function getcity_name(): ?string { return $this->city_name; }
    public function setcity_name(?string $city_name): void { $this->city_name = $city_name; }

    /**
     * Ruft alle Kämpfer aus der Datenbank ab.
     * @return array Eine Liste aller Kämpfer
     */
    public static function all(): array
    {
        $gateway = new FighterGateway(); // Gateway-Instanz erstellen
        return array_map(fn($data) => self::create($data), $gateway->all()); // Alle Kämpfer in Fighter-Objekte umwandeln
    }

    /**
     * Findet einen Kämpfer anhand seiner ID.
     * @param int $id Die ID des Kämpfers
     * @return self|null Das Fighter-Objekt oder null, falls nicht gefunden
     */
    public static function find(int $id): ?self
    {
        $gateway = new FighterGateway(); // Gateway-Instanz erstellen
        $data = $gateway->find($id); // Kämpferdaten aus der Datenbank abrufen
        return $data ? self::create($data) : null; // Fighter-Objekt erstellen, wenn Daten gefunden wurden
    }

    // Speichert den Kämpfer (neu oder aktualisiert).
    public function save(): void
    {
        $gateway = new FighterGateway(); // Gateway-Instanz erstellen
        if (isset($this->id)) {
            $gateway->update($this->id, $this->toArray()); // Update, wenn die ID existiert
        } else {
            $this->id = $gateway->insert($this->toArray()); // Insert, wenn keine ID existiert
        }
    }

    /**
     * Löscht den Kämpfer.
     * @throws \Exception Wenn die ID nicht gesetzt ist
     */
    public function delete(): void
    {
        if (!isset($this->id)) {
            throw new \Exception("Kämpfer-ID nicht gesetzt."); // Fehler werfen, wenn keine ID vorhanden ist
        }
        $gateway = new FighterGateway(); // Gateway-Instanz erstellen
        $gateway->delete($this->id); // Kämpfer löschen
    }

    /**
     * Erstellt ein Fighter-Objekt aus einem Array.
     * @param array $data Die Daten des Kämpfers
     * @return self Ein neues Fighter-Objekt
     */
    private static function create(array $data): self
    {
        $fighter = new self(); // Neue Instanz erstellen
        $fighter->setid((int) $data['id']);
        $fighter->setfull_name($data['full_name']);
        $fighter->setfighter_name($data['fighter_name']);
        $fighter->setbirthdate($data['birthdate']);
        $fighter->setheight((int) $data['height']);
        $fighter->setweight((int) $data['weight']);
        $fighter->setweight_class_id($data['weight_class_id'] ?? null);
        $fighter->setcity_id($data['city_id'] ?? null);
        $fighter->setexperience_level($data['experience_level']);
        $fighter->setweight_class_name($data['weight_class_name'] ?? null);
        $fighter->setcity_name($data['city_name'] ?? null);

        return $fighter; // Fertiges Fighter-Objekt zurückgeben
    }

    /**
     * Gibt die Attribute des Kämpfers als Array zurück.
     * @return array Ein Array mit den Attributen des Kämpfers
     */
    private function toArray(): array
    {
        return [
            "full_name" => $this->full_name,
            "fighter_name" => $this->fighter_name,
            "birthdate" => $this->birthdate,
            "height" => $this->height,
            "weight" => $this->weight,
            "weight_class_id" => $this->weight_class_id,
            "city_id" => $this->city_id,
            "experience_level" => $this->experience_level,
        ]; // Array mit allen relevanten Eigenschaften
    }
}

/**
 * Beschreibung des Codes:
 *
 * - Diese Klasse repräsentiert einen Kämpfer in der Anwendung.
 * - Eigenschaften:
 *   - `id`: Eindeutige ID des Kämpfers.
 *   - `full_name`: Vollständiger Name des Kämpfers.
 *   - `fighter_name`: Kämpfername (Alias).
 *   - `birthdate`: Geburtsdatum des Kämpfers.
 *   - `height`: Größe in cm.
 *   - `weight`: Gewicht in kg.
 *   - `weight_class_id`: ID der zugehörigen Gewichtsklasse.
 *   - `city_id`: ID der zugehörigen Stadt.
 *   - `experience_level`: Erfahrungslevel (z. B. Amateur oder Profi).
 * - CRUD-Methoden:
 *   - `all`: Holt alle Kämpfer.
 *   - `find`: Findet einen Kämpfer anhand der ID.
 *   - `save`: Speichert einen Kämpfer (neu oder aktualisiert).
 *   - `delete`: Löscht einen Kämpfer.
 * - Unterstützt das Erstellen von Kämpfer-Objekten aus Datenbankdaten.
 */
