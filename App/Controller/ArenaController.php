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
