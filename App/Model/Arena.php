<?php

namespace App\Model;

use App\Gateway\ArenaGateway;

class Arena
{
    // Eigenschaften der Arena
    private int $id; // ID der Arena
    private string $name; // Name der Arena
    private int $city_id; // ID der Stadt
    private int $weight_class_id; // ID der Gewichtsklasse
    private ?string $city_name = null; // Name der Stadt (optional, kann NULL sein)
    private ?string $weight_class_name = null; // Name der Gewichtsklasse (optional, kann NULL sein)

    // Getter und Setter für ID
    public function getid(): int { return $this->id; }
    public function setid(int $id): void { $this->id = $id; }

    // Getter und Setter für Name
    public function getname(): string { return $this->name; }
    public function setname(string $name): void { $this->name = $name; }

    // Getter und Setter für Stadt-ID
    public function getcity_id(): int { return $this->city_id; }
    public function setcity_id(int $city_id): void { $this->city_id = $city_id; }

    // Getter und Setter für Gewichtsklassen-ID
    public function getweight_class_id(): int { return $this->weight_class_id; }
    public function setweight_class_id(int $weight_class_id): void { $this->weight_class_id = $weight_class_id; }

    // Getter und Setter für Stadt-Name
    public function getcity_name(): ?string { return $this->city_name; }
    public function setcity_name(?string $city_name): void { $this->city_name = $city_name; }

    // Getter und Setter für Gewichtsklassen-Name
    public function getweight_class_name(): ?string { return $this->weight_class_name; }
    public function setweight_class_name(?string $weight_class_name): void { $this->weight_class_name = $weight_class_name; }

    /**
     * Holt alle Arenen.
     * @return array
     */
    public static function all(): array
    {
        $gateway = new ArenaGateway(); // Instanziiert das Gateway
        $arenas = [];

        // Erstellt Arena-Objekte aus den Gateway-Daten
        foreach ($gateway->all() as $arenaData) {
            $arenas[] = self::create($arenaData);
        }

        return $arenas; // Gibt eine Liste von Arena-Objekten zurück
    }

    /**
     * Findet eine Arena anhand der ID.
     * @param int $id
     * @return self|null
     */
    public static function find(int $id): ?self
    {
        $gateway = new ArenaGateway(); // Instanziiert das Gateway
        $data = $gateway->find($id);

        // Gibt die Arena zurück oder null, wenn keine gefunden wurde
        return $data ? self::create($data) : null;
    }

    // Speichert die Arena (Insert oder Update).
    public function save(): void
    {
        $gateway = new ArenaGateway();

        if (isset($this->id)) {
            // Führt ein Update durch, wenn die ID existiert
            $gateway->update($this->id, $this->toArray());
        } else {
            // Fügt eine neue Arena hinzu
            $this->id = $gateway->insert($this->toArray());
        }
    }

    // Löscht die Arena.
    public function delete(): void
    {
        $gateway = new ArenaGateway(); // Instanziiert das Gateway
        $gateway->delete($this->id); // Löscht die Arena anhand der ID
    }

    /**
     * Erstellt ein Arena-Objekt aus einem Datenbank-Eintrag.
     * @param array $data Die Datenbankdaten
     * @return self
     */
    private static function create(array $data): self
    {
        $arena = new self();
        $arena->setid($data['id']); // Setzt die ID
        $arena->setname($data['name']); // Setzt den Namen
        $arena->setcity_id($data['city_id']); // Setzt die Stadt-ID
        $arena->setweight_class_id($data['weight_class_id']); // Setzt die Gewichtsklassen-ID
        $arena->setcity_name($data['city_name'] ?? null); // Setzt den Stadtnamen (optional)
        $arena->setweight_class_name($data['weight_class_name'] ?? null); // Setzt den Gewichtsklassen-Namen (optional)

        return $arena; // Gibt das erstellte Arena-Objekt zurück
    }

    /**
     * Gibt die Daten der Arena als Array zurück.
     * @return array
     */
    private function toArray(): array
    {
        return [
            "name" => $this->name, // Name der Arena
            "city_id" => $this->city_id, // Stadt-ID
            "weight_class_id" => $this->weight_class_id, // Gewichtsklassen-ID
        ];
    }
}

/**
 * Beschreibung des Codes:
 *
 * - Die Klasse `Arena` repräsentiert eine Arena in der Anwendung.
 * - Eigenschaften:
 *   - `id`, `name`, `city_id`, `weight_class_id`, `city_name`, `weight_class_name`.
 * - CRUD-Methoden:
 *   - `all`: Holt alle Arenen aus der Datenbank.
 *   - `find`: Findet eine Arena anhand der ID.
 *   - `save`: Speichert eine Arena (Insert oder Update).
 *   - `delete`: Löscht eine Arena.
 * - Unterstützt das Konvertieren von Datenbank-Einträgen in Arena-Objekte und zurück.
 */
