<?php

namespace App\Controller;

use App\Model\City;

class CityController extends DefaultController
{
    /**
     * Zeigt eine Liste aller Städte an.
     */
    public function index()
    {
        $cities = City::all(); // Holt alle Städte aus der Datenbank
        $this->render("cities-overview.html.twig", ["cities" => $cities]); // Übergibt die Städte an die View
    }

    /**
     * Speichert eine neue Stadt in der Datenbank.
     *
     * @param array $data Eingabedaten für die neue Stadt
     */
    public function store(array $data)
    {
        // Validierung: Überprüfen, ob der Name der Stadt angegeben wurde
        if (empty($data['name'])) {
            $this->render("cities-form.html.twig", ["error" => "Der Stadtname darf nicht leer sein."]);
            return;
        }

        // Erstellen und Speichern der Stadt
        $city = new City();
        $city->setname($data['name']); // Konsistente Benennung
        try {
            $city->save();
            $this->redirect("/cities"); // Weiterleitung zur Stadtübersicht
        } catch (\Exception $e) {
            $this->render("cities-form.html.twig", ["error" => "Fehler beim Speichern der Stadt: " . $e->getMessage()]);
        }
    }

    /**
     * Löscht eine Stadt aus der Datenbank.
     *
     * @param int $id ID der zu löschenden Stadt
     */
    public function delete(int $id)
    {
        $city = City::find($id); // Holt die Stadt anhand der ID
        if ($city) {
            try {
                $city->delete();
            } catch (\Exception $e) {
                $this->render("cities-overview.html.twig", ["error" => "Fehler beim Löschen der Stadt: " . $e->getMessage()]);
                return;
            }
        }

        $this->redirect("/cities"); // Weiterleitung zur Stadtübersicht
    }
}
