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
     */
    public static function all(): array
    {
        $gateway = new CityGateway();
        return $gateway->all();
    }

    /**
     * Findet eine Stadt anhand der ID.
     */
    public static function find(int $id): ?self
    {
        $gateway = new CityGateway();
        $data = $gateway->find($id);
        return $data ? self::create($data) : null;
    }

    /**
     * Speichert die Stadt (neu oder aktualisiert).
     */
    public function save(): void
    {
        $gateway = new CityGateway();
        if (isset($this->id)) {
            $gateway->update($this->id, ['name' => $this->name]);
        } else {
            $this->id = $gateway->insert(['name' => $this->name]);
        }
    }

    /**
     * Löscht die Stadt.
     */
    public function delete(): void
    {
        if (!isset($this->id)) {
            throw new \Exception("Kann keine Stadt löschen, die nicht existiert.");
        }

        $gateway = new CityGateway();
        $gateway->delete($this->id);
    }

    /**
     * Erstellt eine Instanz aus den Datenbankinformationen.
     */
    private static function create(array $data): self
    {
        $city = new self();
        $city->setid($data['id']);
        $city->setname($data['name']);
        return $city;
    }
}
