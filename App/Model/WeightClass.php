<?php

namespace App\Model;

use App\Gateway\WeightClassGateway;

class WeightClass
{
    private int $id; // ID der Gewichtsklasse
    private string $class_name; // Name der Gewichtsklasse

    // Getter und Setter für ID
    public function getid(): int { return $this->id; } // Getter für ID
    public function setid(int $id): void { $this->id = $id; } // Setter für ID

    // Getter und Setter für Name
    public function getclass_name(): string { return $this->class_name; } // Getter für Name
    public function setclass_name(string $class_name): void { $this->class_name = $class_name; } // Setter für Name

    /**
     * Ruft alle Gewichtsklassen aus der Datenbank ab.
     */
    public static function all(): array
    {
        $gateway = new WeightClassGateway();
        return array_map(fn($data) => self::create($data), $gateway->all());
    }

    /**
     * Findet eine Gewichtsklasse anhand der ID.
     */
    public static function find(int $id): ?self
    {
        $gateway = new WeightClassGateway();
        $data = $gateway->find($id);
        return $data ? self::create($data) : null;
    }

    /**
     * Speichert die Gewichtsklasse (neu oder aktualisiert).
     */
    public function save(): void
    {
        $gateway = new WeightClassGateway();
        if (isset($this->id)) {
            $gateway->update($this->id, ['class_name' => $this->class_name]);
        } else {
            $this->id = $gateway->insert(['class_name' => $this->class_name]);
        }
    }

    /**
     * Löscht die Gewichtsklasse.
     */
    public function delete(): void
    {
        if (!isset($this->id)) {
            throw new \Exception("Kann keine Gewichtsklasse löschen, die nicht existiert.");
        }

        $gateway = new WeightClassGateway();
        $gateway->delete($this->id);
    }

    /**
     * Erstellt eine Instanz aus den Datenbankinformationen.
     */
    private static function create(array $data): self
    {
        $weightClass = new self();
        $weightClass->setid($data['id']);
        $weightClass->setclass_name($data['class_name']);
        return $weightClass;
    }
}
