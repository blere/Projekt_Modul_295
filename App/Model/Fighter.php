<?php

namespace App\Model;

use App\Gateway\FighterGateway;

class Fighter
{
    private int $id;
    private string $full_name;
    private string $fighter_name;
    private string $birthdate;
    private int $height;
    private int $weight;
    private ?int $weight_class_id; // Gewichtsklassen-ID
    private ?int $city_id; // Stadt-ID
    private string $experience_level;
    private ?string $weight_class_name; // Name der Gewichtsklasse
    private ?string $city_name; // Name der Stadt

    // Getter und Setter
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

    // Daten abrufen
    public static function all(): array
    {
        $gateway = new FighterGateway();
        return array_map(fn($data) => self::create($data), $gateway->all());
    }

    // Kämpfer anhand ID finden
    public static function find(int $id): ?self
    {
        $gateway = new FighterGateway();
        $data = $gateway->find($id);
        return $data ? self::create($data) : null;
    }

    // Speichern (Insert oder Update)
    public function save(): void
    {
        $gateway = new FighterGateway();
        if (isset($this->id)) {
            $gateway->update($this->id, $this->toArray());
        } else {
            $this->id = $gateway->insert($this->toArray());
        }
    }

    // Löschen
    public function delete(): void
    {
        if (!isset($this->id)) {
            throw new \Exception("Kämpfer-ID nicht gesetzt.");
        }

        $gateway = new FighterGateway();
        $gateway->delete($this->id);
    }

    // Fighter-Objekt erstellen
    private static function create(array $data): self
    {
        $fighter = new self();
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

        return $fighter;
    }

    // Daten als Array zurückgeben
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
        ];
    }
}
