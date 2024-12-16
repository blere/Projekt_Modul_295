<?php

namespace App\Controller;

use App\Model\Arena;
use App\Model\City;
use App\Model\WeightClass;

class ArenaController extends DefaultController
{
    // Zeigt alle Arenen an
    public function index()
    {
        $arenas = Arena::all();
        $this->render("arenas-overview.html.twig", ["arenas" => $arenas]);
    }

    // Zeigt das Formular zum Erstellen einer neuen Arena
    public function create()
    {
        $cities = City::all();
        $weightClasses = WeightClass::all();
        $this->render("arena-form.html.twig", [
            "cities" => $cities,
            "weightClasses" => $weightClasses,
        ]);
    }

    // Speichert eine neue Arena in der Datenbank
    public function store(array $data)
    {
        $arena = new Arena();
        $arena->setname($data['name']);
        $arena->setcity_id((int) $data['city_id']);
        $arena->setweight_class_id((int) $data['weight_class_id']);
        $arena->save();

        $this->redirect("/arenas");
    }

    // Zeigt das Formular zum Bearbeiten einer bestehenden Arena
    public function edit(int $id)
    {
        $arena = Arena::find($id); // Arena anhand der ID laden
        if (!$arena) {
            $this->redirect("/arenas"); // Zurück, wenn Arena nicht gefunden
        }

        $cities = City::all(); // Alle Städte laden
        $weightClasses = WeightClass::all(); // Alle Gewichtsklassen laden

        $this->render("arena-form.html.twig", [
            "arena" => $arena, // Bestehende Arena übergeben
            "cities" => $cities,
            "weightClasses" => $weightClasses,
        ]);
    }

    // Aktualisiert eine bestehende Arena
    public function update(int $id, array $data)
    {
        $arena = Arena::find($id);
        if (!$arena) {
            $this->redirect("/arenas"); // Zurück, wenn Arena nicht gefunden
        }

        $arena->setname($data['name']);
        $arena->setcity_id((int) $data['city_id']);
        $arena->setweight_class_id((int) $data['weight_class_id']);
        $arena->save();

        $this->redirect("/arenas");
    }

    // Löscht eine Arena
    public function delete(int $id)
    {
        $arena = Arena::find($id);
        if ($arena) {
            $arena->delete();
        }

        $this->redirect("/arenas");
    }
}

/**
 * Beschreibung des Codes:
 * 
 * - index-Methode:
 *   Zeigt eine Übersicht aller Arenen an, indem die Daten mit der `Arena::all()`-Methode geladen und im Template `arenas-overview.html.twig` dargestellt werden.
 * 
 * - create-Methode:
 *   Zeigt ein Formular zum Erstellen einer neuen Arena. Es lädt alle verfügbaren Städte und Gewichtsklassen, um sie im Formular als Auswahloptionen bereitzustellen.
 * 
 * - store-Methode:
 *   Speichert eine neue Arena in der Datenbank. Die Eingabedaten werden in ein neues `Arena`-Objekt übergeben und gespeichert.
 * 
 * - edit-Methode:
 *   Lädt eine bestehende Arena anhand der ID und zeigt ein Formular zur Bearbeitung der Daten. Falls die Arena nicht gefunden wird, erfolgt eine Weiterleitung zur Arena-Übersicht.
 * 
 * - update-Methode:
 *   Aktualisiert eine bestehende Arena in der Datenbank mit den übergebenen Formulardaten. Falls die Arena nicht existiert, erfolgt eine Weiterleitung zur Übersicht.
 * 
 * - delete-Methode:
 *   Löscht eine bestehende Arena aus der Datenbank. Nach erfolgreicher Löschung erfolgt eine Weiterleitung zur Arena-Übersicht.
 */
