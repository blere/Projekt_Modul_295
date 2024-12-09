<?php

namespace App\Model;

use App\Gateway\ArenaGateway;

class Arena
{
    private int $id;
    private string $name;
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

    // Alle Arenen abrufen
    public static function all(): array
    {
        $gateway = new ArenaGateway();
        $arenas = [];

        foreach ($gateway->all() as $arenaData) {
            $arenas[] = self::create($arenaData);
        }

        return $arenas;
    }

    // Eine Arena anhand der ID finden
    public static function find(int $id): ?self
    {
        $gateway = new ArenaGateway();
        $data = $gateway->find($id);

        return $data ? self::create($data) : null;
    }

    // Arena speichern (Insert oder Update)
    public function save(): void
    {
        $gateway = new ArenaGateway();

        if (isset($this->id)) {
            $gateway->update($this->id, $this->toArray());
        } else {
            $this->id = $gateway->insert($this->toArray());
        }
    }

    // Arena löschen
    public function delete(): void
    {
        $gateway = new ArenaGateway();
        $gateway->delete($this->id);
    }

    // Arena aus Datenbank-Daten erstellen
    private static function create(array $data): self
    {
        $arena = new self();
        $arena->setid($data['id']);
        $arena->setname($data['name']);
        $arena->setcity_id($data['city_id']);
        $arena->setweight_class_id($data['weight_class_id']);
        $arena->setcity_name($data['city_name'] ?? null);
        $arena->setweight_class_name($data['weight_class_name'] ?? null);

        return $arena;
    }

    // Daten der Arena als Array
    private function toArray(): array
    {
        return [
            "name" => $this->name,
            "city_id" => $this->city_id,
            "weight_class_id" => $this->weight_class_id,
        ];
    }
}
