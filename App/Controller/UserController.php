<?php

namespace App\Controller;

use App\Model\User;

class UserController extends DefaultController
{
    // Zeigt das Login-Formular an.
    public function loginForm(): void
    {
        $this->render("login.html.twig");
    }

    // Zeigt das Registrierungsformular an.
    public function registerForm(): void
    {
        $this->render("register.html.twig");
    }

    /**
     * Verarbeitet den Login eines Benutzers.
     * @param array $data Die Formulardaten (Benutzername und Passwort).
     */
    public function login(array $data): void
    {
        if (empty($data['username']) || empty($data['password'])) {
            $this->render("login.html.twig", ["error" => "Benutzername und Passwort dürfen nicht leer sein."]);
            return;
        }

        $user = User::findByUsername($data['username']);
        if ($user && password_verify($data['password'], $user->getPasswordHash())) {
            $_SESSION['user_id'] = $user->getId(); // Benutzer-ID in der Sitzung speichern
            $this->redirect("/home"); // Weiterleitung zur Startseite
        } else {
            $this->render("login.html.twig", ["error" => "Ungültige Anmeldedaten."]);
        }
    }

    /**
     * Verarbeitet die Registrierung eines neuen Benutzers.
     * @param array $data Die Formulardaten (Vorname, Nachname, E-Mail, Benutzername und Passwort).
     */
    public function register(array $data): void
    {
        try {
            if (
                empty($data['firstname']) || 
                empty($data['lastname']) || 
                empty($data['email']) || 
                empty($data['username']) || 
                empty($data['password']) || 
                empty($data['confirm_password'])
            ) {
                $this->render("register.html.twig", ["error" => "Alle Felder sind erforderlich."]);
                return;
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->render("register.html.twig", ["error" => "Ungültige E-Mail-Adresse."]);
                return;
            }

            if ($data['password'] !== $data['confirm_password']) {
                $this->render("register.html.twig", ["error" => "Die Passwörter stimmen nicht überein."]);
                return;
            }

            if (User::findByUsername($data['username'])) {
                $this->render("register.html.twig", ["error" => "Benutzername ist bereits vergeben."]);
                return;
            }

            $user = new User();
            $user->setFirstname($data['firstname']); // Setzt den Vornamen
            $user->setLastname($data['lastname']); // Setzt den Nachnamen
            $user->setEmail($data['email']); // Setzt die E-Mail-Adresse
            $user->setUsername($data['username']); // Setzt den Benutzernamen
            $user->setPasswordHash(password_hash($data['password'], PASSWORD_DEFAULT)); // Setzt das verschlüsselte Passwort
            $user->save(); // Speichert den Benutzer in der Datenbank

            $_SESSION['user_id'] = $user->getId(); // Benutzer-ID in der Sitzung speichern
            $this->redirect("/home"); // Weiterleitung zur Startseite
        } catch (\PDOException $e) {
            // Überprüfen, ob der Fehler durch eine doppelte E-Mail-Adresse oder einen Benutzernamen verursacht wurde
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $this->render("register.html.twig", ["error" => "E-Mail-Adresse oder Benutzername ist bereits registriert."]);
            } else {
                throw $e; // Alle anderen Fehler weitergeben
            }
        }
    }

    // Loggt den Benutzer aus und zerstört die Sitzung.
    public function logout(): void
    {
        session_destroy(); // Beendet die Sitzung
        $this->redirect("/login"); // Weiterleitung zur Login-Seite
    }
}

/**
 * Beschreibung des Codes:
 *
 * - `loginForm`:
 *   - Zeigt das Login-Formular an.
 * 
 * - `registerForm`:
 *   - Zeigt das Registrierungsformular an.
 *
 * - `login`:
 *   - Überprüft die Anmeldedaten (Benutzername und Passwort).
 *   - Leitet den Benutzer bei erfolgreicher Anmeldung zur Startseite weiter.
 *   - Zeigt eine Fehlermeldung bei ungültigen Anmeldedaten.
 *
 * - `register`:
 *   - Überprüft die Formulardaten (Vorname, Nachname, E-Mail, Benutzername, Passwort).
 *   - Stellt sicher, dass E-Mail-Adresse und Benutzername eindeutig sind.
 *   - Speichert einen neuen Benutzer in der Datenbank.
 *   - Zeigt eine Fehlermeldung, wenn die Daten ungültig oder doppelt vorhanden sind.
 *
 * - `logout`:
 *   - Zerstört die aktuelle Sitzung und leitet zur Login-Seite weiter.
 */
