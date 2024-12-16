<?php

namespace App\Controller;

use App\Model\Fight;
use App\Model\Fighter;
use App\Model\Arena;

class FightController extends DefaultController
{
    // Zeigt die Liste aller Kämpfe.
    public function index()
    {
        $fights = Fight::all(); // Holt alle Kämpfe
        $this->render("fights-overview.html.twig", ["fights" => $fights]);
    }

    // Zeigt das Formular zum Erstellen eines neuen Kampfes.
    public function create()
    {
        $arenas = Arena::all(); // Holt alle Arenen
        $fighters = Fighter::all(); // Holt alle Kämpfer

        $this->render("fight-form.html.twig", [
            "arenas" => $arenas,
            "fighters" => $fighters,
        ]);
    }

    /**
     * Speichert einen neuen Kampf.
     * @param array $data Die Formulardaten
     */
    public function store(array $data)
    {
        $fight = new Fight();
        $fight->setfighter1_id((int)$data['fighter1_id']);
        $fight->setfighter2_id((int)$data['fighter2_id']);
        $fight->setarena_id((int)$data['arena_id']);
        $fight->setdate($data['date']);
        $fight->setcontact_type($data['contact_type']);
        $fight->setresult($data['result']);

        try {
            $fight->save(); // Speichert den neuen Kampf
            $this->redirect("/fights");
        } catch (\Exception $e) {
            $arenas = Arena::all();
            $fighters = Fighter::all();

            $this->render("fight-form.html.twig", [
                "arenas" => $arenas,
                "fighters" => $fighters,
                "error" => "Fehler beim Speichern: " . $e->getMessage(),
            ]);
        }
    }

    /**
     * Zeigt das Formular zum Bearbeiten eines bestehenden Kampfes.
     * @param int $id Die ID des zu bearbeitenden Kampfes
     */
    public function edit(int $id)
    {
        $fight = Fight::find($id);
        if (!$fight) {
            $this->redirect("/fights");
        }

        $arenas = Arena::all();
        $fighters = Fighter::all();

        $this->render("fight-form.html.twig", [
            "fight" => $fight,
            "arenas" => $arenas,
            "fighters" => $fighters,
        ]);
    }

    /**
     * Aktualisiert einen bestehenden Kampf.
     * @param int $id Die ID des Kampfes
     * @param array $data Die aktualisierten Daten
     */
    public function update(int $id, array $data)
    {
        $fight = Fight::find($id);
        if (!$fight) {
            $this->redirect("/fights");
        }

        $fight->setfighter1_id((int)$data['fighter1_id']);
        $fight->setfighter2_id((int)$data['fighter2_id']);
        $fight->setarena_id((int)$data['arena_id']);
        $fight->setdate($data['date']);
        $fight->setcontact_type($data['contact_type']);
        $fight->setresult($data['result']);

        try {
            $fight->save(); // Speichert die Änderungen
            $this->redirect("/fights");
        } catch (\Exception $e) {
            $arenas = Arena::all();
            $fighters = Fighter::all();

            $this->render("fight-form.html.twig", [
                "fight" => $fight,
                "arenas" => $arenas,
                "fighters" => $fighters,
                "error" => "Fehler beim Aktualisieren: " . $e->getMessage(),
            ]);
        }
    }

    /**
     * Löscht einen Kampf.
     * @param int $id Die ID des Kampfes
     */
    public function delete(int $id)
    {
        $fight = Fight::find($id);
        if ($fight) {
            $fight->delete();
        }

        $this->redirect("/fights");
    }
}

/**
 * Beschreibung des Codes:
 * 
 * - index-Methode:
 *   Lädt alle Kämpfe aus der Datenbank mittels `Fight::all()` und übergibt sie an die View `fights-overview.html.twig`, um die Liste anzuzeigen.
 * 
 * - create-Methode:
 *   Zeigt ein Formular zum Erstellen eines neuen Kampfes an. Lädt alle Arenen und Kämpfer und übergibt sie an die View `fight-form.html.twig`.
 * 
 * - store-Methode:
 *   Speichert die Daten eines neuen Kampfes in der Datenbank. Bei einem Fehler wird das Formular erneut angezeigt, mit einer Fehlermeldung.
 * 
 * - edit-Methode:
 *   Zeigt das Formular zum Bearbeiten eines bestehenden Kampfes an. Lädt die Details des Kampfes, sowie Arenen und Kämpfer.
 * 
 * - update-Methode:
 *   Aktualisiert die Daten eines bestehenden Kampfes in der Datenbank. Bei einem Fehler wird das Formular erneut mit einer Fehlermeldung angezeigt.
 * 
 * - delete-Methode:
 *   Löscht einen Kampf anhand seiner ID aus der Datenbank. Leitet anschließend zur Kampf-Übersicht weiter.
 */
