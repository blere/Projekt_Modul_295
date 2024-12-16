<?php

namespace App\Controller;

use App\Model\Fighter;
use App\Model\Arena;
use App\Model\Fight;

class HomeController extends DefaultController
{
    // Zeigt die Startseite an, inklusive Kämpfer-, Arena- und Kampf-Übersicht.
    public function index()
    {
        $this->checkAuthentication(); // Überprüft, ob der Benutzer authentifiziert ist
        $fighters = Fighter::all(); // Holt alle Kämpfer aus der Datenbank
        $arenas = Arena::all(); // Holt alle Arenen aus der Datenbank
        $fights = Fight::all(); // Holt alle Kämpfe aus der Datenbank

        // Rendert die Startseite und übergibt die geladenen Daten
        $this->render("home.html.twig", [
            "fighters" => $fighters,
            "arenas" => $arenas,
            "fights" => $fights,
        ]);
    }
}

/**
 * Beschreibung des Codes:
 *
 * - index-Methode:
 *   - Führt die Authentifizierungsprüfung mit `checkAuthentication()` durch, um sicherzustellen, dass nur angemeldete Benutzer Zugriff haben.
 *   - Lädt alle Kämpfer, Arenen und Kämpfe aus der Datenbank mit den statischen Methoden `Fighter::all()`, `Arena::all()` und `Fight::all()`.
 *   - Übergibt die geladenen Daten (`fighters`, `arenas`, `fights`) an die View `home.html.twig`, die die Startseite darstellt.
 */
