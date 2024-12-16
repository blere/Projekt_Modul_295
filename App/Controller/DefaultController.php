<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class DefaultController
{
    private Environment $twig;

    public function __construct()
    {
        // Initialisiert den Twig-Loader mit dem Verzeichnis "views".
        $loader = new FilesystemLoader("views");

        // Erstellt eine Twig-Umgebung ohne Cache und aktiviert den Debug-Modus.
        $this->twig = new Environment($loader, [
            'cache' => false, // Kein Caching für die Entwicklung.
            'debug' => true,  // Debug-Modus aktivieren.
        ]);

        // Fügt die globale Variable "session" hinzu, um sie in Templates verfügbar zu machen.
        $this->twig->addGlobal('session', $_SESSION);
    }

    protected function render(string $view, array $params = [])
    {
        // Rendert das Template mit den angegebenen Parametern.
        echo $this->twig->render($view, $params);
    }

    protected function redirect(string $path)
    {
        // Sendet einen HTTP-Redirect und beendet das Skript.
        header("Location: $path");
        exit();
    }

    protected function checkAuthentication()
    {
        // Prüft, ob die Benutzer-ID in der Session gesetzt ist.
        if (empty($_SESSION['user_id'])) {
            $this->redirect("/login"); // Umleiten zur Login-Seite, wenn nicht angemeldet.
        }
    }
}

/**
 * Beschreibung des Codes:
 * 
 * Konstruktor:
 * - Initialisiert den Twig-Loader mit dem Verzeichnis "views".
 * - Aktiviert Debugging und deaktiviert Caching für die Entwicklungsumgebung.
 * - Fügt die globale "session"-Variable hinzu, damit sie in Twig-Templates genutzt werden kann.
 * 
 * render-Methode:
 * - Rendert ein Template mit Twig und gibt es als HTML aus.
 * - Ermöglicht das Übergeben von Variablen/Parametern an das Template.
 * 
 * redirect-Methode:
 * - Führt eine HTTP-Umleitung zu einem angegebenen Pfad durch.
 * - Beendet die aktuelle Skriptausführung nach der Umleitung.
 * 
 * checkAuthentication-Methode:
 * - Prüft, ob der Benutzer angemeldet ist (Session-Variable "user_id").
 * - Wenn der Benutzer nicht authentifiziert ist, wird er zur Login-Seite weitergeleitet.
 */
