<?php

namespace App\Controller;

use App\Model\Fighter;
use App\Model\City;
use App\Model\WeightClass;

class FighterController extends DefaultController
{
    // Zeigt die Übersicht aller Kämpfer.
    public function index()
    {
        $fighters = Fighter::all();
        $this->render("fighters-overview.html.twig", ["fighters" => $fighters]);
    }

    //Zeigt das Formular zum Erstellen eines neuen Kämpfers.
    public function create()
    {
        $cities = City::all();
        $weightClasses = WeightClass::all();
        $this->render("fighter-form.html.twig", ["cities" => $cities, "weightClasses" => $weightClasses]);
    }

    /**
     * Speichert einen neuen Kämpfer in der Datenbank.
     * @param array $data Die Formulardaten des neuen Kämpfers.
     */
    public function store(array $data)
    {
        $fighter = new Fighter();
        $fighter->setfull_name($data['full_name']);
        $fighter->setfighter_name($data['fighter_name']);
        $fighter->setbirthdate($data['birthdate']);
        $fighter->setheight((int) $data['height']);
        $fighter->setweight((int) $data['weight']);
        $fighter->setweight_class_id((int) $data['weight_class_id']);
        $fighter->setcity_id((int) $data['city_id']);
        $fighter->setexperience_level($data['experience_level']);

        try {
            $fighter->save();
            $this->redirect("/fighters");
        } catch (\Exception $e) {
            $cities = City::all();
            $weightClasses = WeightClass::all();

            $this->render("fighter-form.html.twig", [
                "cities" => $cities,
                "weightClasses" => $weightClasses,
                "error" => "Fehler beim Speichern: " . $e->getMessage(),
            ]);
        }
    }

    /**
     * Zeigt das Formular zum Bearbeiten eines bestehenden Kämpfers.
     * @param int $id Die ID des zu bearbeitenden Kämpfers.
     */
    public function edit(int $id)
    {
        $fighter = Fighter::find($id);
        if (!$fighter) {
            $this->redirect("/fighters");
        }

        $cities = City::all();
        $weightClasses = WeightClass::all();

        $this->render("fighter-form.html.twig", [
            "fighter" => $fighter,
            "cities" => $cities,
            "weightClasses" => $weightClasses,
        ]);
    }

    /**
     * Aktualisiert die Daten eines bestehenden Kämpfers.
     * @param int $id Die ID des Kämpfers.
     * @param array $data Die aktualisierten Daten des Kämpfers.
     */
    public function update(int $id, array $data)
    {
        $fighter = Fighter::find($id);
        if (!$fighter) {
            $this->redirect("/fighters");
        }

        $fighter->setfull_name($data['full_name']);
        $fighter->setfighter_name($data['fighter_name']);
        $fighter->setbirthdate($data['birthdate']);
        $fighter->setheight((int) $data['height']);
        $fighter->setweight((int) $data['weight']);
        $fighter->setweight_class_id((int) $data['weight_class_id']);
        $fighter->setcity_id((int) $data['city_id']);
        $fighter->setexperience_level($data['experience_level']);

        try {
            $fighter->save();
            $this->redirect("/fighters");
        } catch (\Exception $e) {
            $cities = City::all();
            $weightClasses = WeightClass::all();

            $this->render("fighter-form.html.twig", [
                "fighter" => $fighter,
                "cities" => $cities,
                "weightClasses" => $weightClasses,
                "error" => "Fehler beim Aktualisieren: " . $e->getMessage(),
            ]);
        }
    }

    /**
     * Löscht einen Kämpfer anhand der ID.
     * @param int $id
     */
    public function delete(int $id)
    {
        $fighter = Fighter::find($id);
        if ($fighter) {
            try {
                $fighter->delete();
            } catch (\Exception $e) {
                $this->render("fighters-overview.html.twig", [
                    "error" => "Kämpfer konnte nicht gelöscht werden: " . $e->getMessage(),
                    "fighters" => Fighter::all(),
                ]);
                return;
            }
        }
        $this->redirect("/fighters");
    }
}

/**
 * Beschreibung des Codes:
 * 
 * - index-Methode:
 *   Lädt alle Kämpfer aus der Datenbank mittels `Fighter::all()` und übergibt sie an die View `fighters-overview.html.twig`, um die Liste anzuzeigen.
 * 
 * - create-Methode:
 *   Zeigt ein Formular zum Erstellen eines neuen Kämpfers. Lädt dazu die verfügbaren Städte und Gewichtsklassen und übergibt sie an die View `fighter-form.html.twig`.
 * 
 * - store-Methode:
 *   Speichert die Daten eines neuen Kämpfers in der Datenbank. Bei einem Fehler wird das Formular erneut angezeigt, mit einer Fehlermeldung.
 * 
 * - edit-Methode:
 *   Zeigt das Formular zum Bearbeiten eines bestehenden Kämpfers an. Lädt dazu die Daten des Kämpfers, sowie verfügbare Städte und Gewichtsklassen.
 * 
 * - update-Methode:
 *   Aktualisiert die Daten eines bestehenden Kämpfers in der Datenbank. Bei einem Fehler wird das Formular erneut mit einer Fehlermeldung angezeigt.
 * 
 * - delete-Methode:
 *   Löscht einen Kämpfer anhand seiner ID aus der Datenbank. Bei einem Fehler wird eine Fehlermeldung in der Kämpfer-Übersicht angezeigt.
 */
