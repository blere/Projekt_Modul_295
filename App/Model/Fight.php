<?php

namespace App\Model;

use App\Gateway\FightGateway;

class Fight
{
    private int $id; // ID des Kampfes
    private int $fighter1_id; // ID von Kämpfer 1
    private int $fighter2_id; // ID von Kämpfer 2
    private int $arena_id; // ID der Arena
    private string $date; // Datum des Kampfes
    private string $contact_type; // Kontaktart (z.B. Leichtkontakt, Vollkontakt)
    private ?string $result; // Ergebnis des Kampfes (optional)
    private ?string $fighter1_name; // Name des Kämpfers 1 (optional)
    private ?string $fighter2_name; // Name des Kämpfers 2 (optional)
    private ?string $arena_name; // Name der Arena (optional)

    // Getter und Setter für ID
    public function getid(): int { return $this->id; }
    public function setid(int $id): void { $this->id = $id; }

    // Getter und Setter für Kämpfer 1 ID
    public function getfighter1_id(): int { return $this->fighter1_id; }
    public function setfighter1_id(int $fighter1_id): void { $this->fighter1_id = $fighter1_id; }

    // Getter und Setter für Kämpfer 2 ID
    public function getfighter2_id(): int { return $this->fighter2_id; }
    public function setfighter2_id(int $fighter2_id): void { $this->fighter2_id = $fighter2_id; }

    // Getter und Setter für Arena ID
    public function getarena_id(): int { return $this->arena_id; }
    public function setarena_id(int $arena_id): void { $this->arena_id = $arena_id; }

    // Getter und Setter für Datum
    public function getdate(): string { return $this->date; }
    public function setdate(string $date): void { $this->date = $date; }

    // Getter und Setter für Kontaktart
    public function getcontact_type(): string { return $this->contact_type; }
    public function setcontact_type(string $contact_type): void { $this->contact_type = $contact_type; }

    // Getter und Setter für Ergebnis
    public function getresult(): ?string { return $this->result; }
    public function setresult(?string $result): void { $this->result = $result; }

    // Getter und Setter für Kämpfer 1 Name
    public function getfighter1_name(): ?string { return $this->fighter1_name; }
    public function setfighter1_name(?string $fighter1_name): void { $this->fighter1_name = $fighter1_name; }

    // Getter und Setter für Kämpfer 2 Name
    public function getfighter2_name(): ?string { return $this->fighter2_name; }
    public function setfighter2_name(?string $fighter2_name): void { $this->fighter2_name = $fighter2_name; }

    // Getter und Setter für Arena Name
    public function getarena_name(): ?string { return $this->arena_name; }
    public function setarena_name(?string $arena_name): void { $this->arena_name = $arena_name; }

    /**
     * Holt alle Kämpfe aus der Datenbank.
     * @return array Eine Liste aller Kämpfe
     */
    public static function all(): array
    {
        $gateway = new FightGateway(); // Gateway-Instanz erstellen
        $fights = [];
        foreach ($gateway->all() as $fightData) {
            $fights[] = self::create($fightData); // Fight-Objekte erstellen
        }
        return $fights;
    }

    /**
     * Findet einen Kampf anhand der ID.
     * @param int $id Die ID des Kampfes
     * @return self|null Das Fight-Objekt oder null, falls nicht gefunden
     */
    public static function find(int $id): ?self
    {
        $gateway = new FightGateway(); // Gateway-Instanz erstellen
        $fightData = $gateway->find($id);
        if ($fightData) {
            return self::create($fightData); // Fight-Objekt erstellen
        }
        return null;
    }

    // Speichert einen neuen oder aktualisierten Kampf.
    public function save(): void
    {
        $gateway = new FightGateway(); // Gateway-Instanz erstellen
        if (isset($this->id)) {
            $gateway->update($this->id, $this->toArray()); // Update, falls ID existiert
        } else {
            $this->id = $gateway->insert($this->toArray()); // Insert, falls keine ID existiert
        }
    }

    /**
     * Löscht einen Kampf anhand der ID.
     * @throws \Exception Wenn die ID nicht gesetzt ist
     */
    public function delete(): void
    {
        if (!isset($this->id)) {
            throw new \Exception("Kampf ID nicht gesetzt.");
        }
        $gateway = new FightGateway(); // Gateway-Instanz erstellen
        $gateway->delete($this->id); // Kampf löschen
    }

    /**
     * Erstellt ein Fight-Objekt aus einem Array.
     * @param array $data Die Daten des Kampfes
     * @return self Ein neues Fight-Objekt
     */
    private static function create(array $data): self
    {
        $fight = new self(); // Neue Instanz erstellen
        $fight->setid((int)$data['id']);
        $fight->setfighter1_id((int)$data['fighter1_id']);
        $fight->setfighter2_id((int)$data['fighter2_id']);
        $fight->setarena_id((int)$data['arena_id']);
        $fight->setdate($data['date']);
        $fight->setcontact_type($data['contact_type']);
        $fight->setresult($data['result'] ?? null);
        $fight->setfighter1_name($data['fighter1_name'] ?? null);
        $fight->setfighter2_name($data['fighter2_name'] ?? null);
        $fight->setarena_name($data['arena_name'] ?? null);
        return $fight;
    }

    /**
     * Gibt die Attribute des Kampfes als Array zurück.
     * @return array Ein Array mit den Attributen des Kampfes
     */
    private function toArray(): array
    {
        return [
            'fighter1_id' => $this->fighter1_id,
            'fighter2_id' => $this->fighter2_id,
            'arena_id' => $this->arena_id,
            'date' => $this->date,
            'contact_type' => $this->contact_type,
            'result' => $this->result,
        ];
    }
}

/**
 * Beschreibung des Codes:
 *
 * - Diese Klasse repräsentiert einen Kampf in der Anwendung.
 * - Eigenschaften:
 *   - `id`: Die eindeutige ID des Kampfes.
 *   - `fighter1_id`, `fighter2_id`: IDs der Kämpfer.
 *   - `arena_id`: Die ID der Arena.
 *   - `date`: Datum des Kampfes.
 *   - `contact_type`: Kontaktart (Leichtkontakt/Vollkontakt).
 *   - `result`: Ergebnis des Kampfes.
 * - CRUD-Methoden:
 *   - `all`: Holt alle Kämpfe.
 *   - `find`: Findet einen Kampf anhand der ID.
 *   - `save`: Speichert einen Kampf (neu oder aktualisiert).
 *   - `delete`: Löscht einen Kampf anhand der ID.
 * - Unterstützt das Erstellen von Kampf-Objekten aus Datenbankdaten.
 */
