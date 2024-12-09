<?php

namespace App\Controller;

use App\Model\Fighter;
use App\Model\City;
use App\Model\WeightClass;

class FighterController extends DefaultController
{
    public function index()
    {
        $fighters = Fighter::all();
        $this->render("fighters-overview.html.twig", ["fighters" => $fighters]);
    }

    public function create()
    {
        $cities = City::all();
        $weightClasses = WeightClass::all();
        $this->render("fighter-form.html.twig", ["cities" => $cities, "weightClasses" => $weightClasses]);
    }

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
     *
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
