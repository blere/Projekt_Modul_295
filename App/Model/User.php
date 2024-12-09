<?php

namespace App\Model;

use App\Gateway\UserGateway;

class User
{
    private int $id; // ID des Benutzers
    private string $firstname = ""; // Vorname des Benutzers
    private string $lastname = ""; // Nachname des Benutzers
    private string $email = ""; // E-Mail-Adresse des Benutzers
    private string $username = ""; // Benutzername
    private string $password_hash = ""; // Passwort-Hash

    // Getter und Setter für id
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Getter und Setter für firstname
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    // Getter und Setter für lastname
    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    // Getter und Setter für email
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Getter und Setter für username
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    // Getter und Setter für password_hash
    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function setPasswordHash(string $password_hash): void
    {
        $this->password_hash = $password_hash;
    }

    /**
     * Findet einen Benutzer anhand des Benutzernamens.
     *
     * @param string $username
     * @return self|null Gibt den Benutzer zurück, falls gefunden, ansonsten null.
     */
    public static function findByUsername(string $username): ?self
    {
        $gateway = new UserGateway();
        $data = $gateway->findByUsername($username);

        return $data ? self::create($data) : null;
    }

    /**
     * Speichert den Benutzer (neu oder aktualisiert).
     */
    public function save(): void
    {
        $gateway = new UserGateway();

        $userData = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'username' => $this->username,
            'password_hash' => $this->password_hash,
        ];

        if (isset($this->id)) {
            // Aktualisiert den bestehenden Benutzer
            $gateway->update($this->id, $userData);
        } else {
            // Fügt einen neuen Benutzer hinzu und setzt die ID
            $this->id = $gateway->insert($userData);
        }
    }

    /**
     * Erstellt eine Instanz von User aus den Datenbankergebnissen.
     *
     * @param array $data Array mit Benutzerdaten aus der Datenbank.
     * @return self Gibt eine User-Instanz zurück.
     */
    private static function create(array $data): self
    {
        $user = new self();
        $user->id = (int)$data['id'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->username = $data['username'];
        $user->password_hash = $data['password_hash'];

        return $user;
    }
}
