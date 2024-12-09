<?php

namespace App\Controller;

use App\Model\User;

class UserController extends DefaultController
{
    /**
     * Zeigt das Login-Formular an.
     */
    public function loginForm(): void
    {
        $this->render("login.html.twig");
    }

    /**
     * Zeigt das Registrierungsformular an.
     */
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
            $_SESSION['user_id'] = $user->getId();// Session Id Speichern
            $this->redirect("/home");
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
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setEmail($data['email']);
            $user->setUsername($data['username']);
            $user->setPasswordHash(password_hash($data['password'], PASSWORD_DEFAULT));
            $user->save();

            $_SESSION['user_id'] = $user->getId();
            $this->redirect("/home");
        } catch (\PDOException $e) {
            // Überprüfen, ob der Fehler durch eine doppelte E-Mail-Adresse verursacht wurde
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $this->render("register.html.twig", ["error" => "E-Mail-Adresse oder Benutzername ist bereits registriert."]);
            } else {
                throw $e; // Alle anderen Fehler weitergeben
            }
        }
    }

    /**
     * Loggt den Benutzer aus und Zerstören die Sitzung.
     */
    public function logout(): void
    {
        session_destroy();
        $this->redirect("/login");
    }
}
