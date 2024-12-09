<?php

namespace App\Model;

use App\Gateway\FightGateway;

class Fight
{
    private int $id;
    private int $fighter1_id;
    private int $fighter2_id;
    private int $arena_id;
    private string $date;
    private string $contact_type;
    private ?string $result;
    private ?string $fighter1_name; // Name des Kämpfers 1
    private ?string $fighter2_name; // Name des Kämpfers 2
    private ?string $arena_name; // Name der Arena

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
     */
    public static function all(): array
    {
        $gateway = new FightGateway();
        $fights = [];
        foreach ($gateway->all() as $fightData) {
            $fights[] = self::create($fightData);
        }
        return $fights;
    }

    /**
     * Findet einen Kampf anhand der ID.
     */
    public static function find(int $id): ?self
    {
        $gateway = new FightGateway();
        $fightData = $gateway->find($id);
        if ($fightData) {
            return self::create($fightData);
        }
        return null;
    }

    /**
     * Speichert einen neuen oder aktualisierten Kampf.
     */
    public function save(): void
    {
        $gateway = new FightGateway();
        if (isset($this->id)) {
            $gateway->update($this->id, $this->toArray());
        } else {
            $this->id = $gateway->insert($this->toArray());
        }
    }

    /**
     * Löscht einen Kampf anhand der ID.
     */
    public function delete(): void
    {
        if (!isset($this->id)) {
            throw new \Exception("Kampf ID nicht gesetzt.");
        }
        $gateway = new FightGateway();
        $gateway->delete($this->id);
    }

    /**
     * Erstellt ein Fight-Objekt aus einem Array.
     */
    private static function create(array $data): self
    {
        $fight = new self();
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
