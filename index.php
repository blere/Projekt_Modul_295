<?php

use App\Controller\HomeController;
use App\Controller\FighterController;
use App\Controller\ArenaController;
use App\Controller\FightController;
use App\Controller\UserController;

require_once "vendor/autoload.php";

// Startet die Session, um Benutzerinformationen während der Sitzung zu speichern
session_start();

// Definiert die verfügbaren Routen und deren zugehörige Controller-Methoden
$routes = [
    "GET" => [
        "/" => [UserController::class, "loginForm"], // Login-Seite als Standardseite
        "/home" => [HomeController::class, "index"], // Startseite mit Übersicht
        "/fighters" => [FighterController::class, "index"], // Übersicht der Kämpfer
        "/fighters/create" => [FighterController::class, "create"], // Formular für neuen Kämpfer
        "/fighters/edit/{id}" => [FighterController::class, "edit"], // Formular zum Bearbeiten eines Kämpfers
        "/fighters/delete/{id}" => [FighterController::class, "delete"], // Löschen eines Kämpfers
        "/arenas" => [ArenaController::class, "index"], // Übersicht der Arenen
        "/arenas/create" => [ArenaController::class, "create"], // Formular für neue Arena
        "/arenas/edit/{id}" => [ArenaController::class, "edit"], // Formular zum Bearbeiten einer Arena
        "/arenas/delete/{id}" => [ArenaController::class, "delete"], // Löschen einer Arena
        "/fights" => [FightController::class, "index"], // Übersicht der Kämpfe
        "/fights/create" => [FightController::class, "create"], // Formular für neuen Kampf
        "/fights/edit/{id}" => [FightController::class, "edit"], // Formular zum Bearbeiten eines Kampfes
        "/fights/delete/{id}" => [FightController::class, "delete"], // Löschen eines Kampfes
        "/login" => [UserController::class, "loginForm"], // Login-Formular
        "/logout" => [UserController::class, "logout"], // Benutzer abmelden
        "/register" => [UserController::class, "registerForm"], // Registrierungsformular
    ],
    "POST" => [
        "/fighters/create" => [FighterController::class, "store"], // Speichert neuen Kämpfer
        "/fighters/edit/{id}" => [FighterController::class, "update"], // Aktualisiert Kämpferdaten
        "/arenas/create" => [ArenaController::class, "store"], // Speichert neue Arena
        "/arenas/edit/{id}" => [ArenaController::class, "update"], // Aktualisiert Arenadaten
        "/fights/create" => [FightController::class, "store"], // Speichert neuen Kampf
        "/fights/edit/{id}" => [FightController::class, "update"], // Aktualisiert Kampfdaten
        "/login" => [UserController::class, "login"], // Verarbeitet Login
        "/register" => [UserController::class, "register"], // Verarbeitet Registrierung
    ]
];

// Holt die aktuelle URI und die verwendete HTTP-Methode
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); // Extrahiert den Pfad aus der URL
$method = $_SERVER["REQUEST_METHOD"]; // Holt die HTTP-Methode (GET/POST)

// Iteriert durch die definierten Routen, um die passende zu finden
foreach ($routes[$method] as $route => $action) {
    // Erstellt ein reguläres Ausdrucksmuster für die Route (z. B. für {id})
    $pattern = "@^" . preg_replace('/\{[a-zA-Z0-9_]+\}/', '([0-9]+)', $route) . "$@";

    // Prüft, ob die aktuelle URI mit dem Muster übereinstimmt
    if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches); // Entfernt den vollständigen Match aus den Ergebnissen
        [$controllerClass, $method] = $action; // Teilt Controller und Methode auf
        $controller = new $controllerClass(); // Erstellt eine Instanz des Controllers

        // Führt die Methode aus, je nach HTTP-Methode
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $controller->$method(...array_merge($matches, [$_POST])); // POST-Daten übergeben
        } else {
            $controller->$method(...$matches); // GET-Daten (z. B. IDs) übergeben
        }
        exit; // Beendet das Skript nach der Verarbeitung
    }
}

// Gibt eine 404-Fehlermeldung aus, wenn keine passende Route gefunden wird
http_response_code(404);
echo "Seite nicht gefunden!";
