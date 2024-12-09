<?php

namespace App\Controller;

use App\Model\WeightClass;

class WeightClassController extends DefaultController
{
    /**
     * Zeigt eine Liste aller Gewichtsklassen an.
     */
    public function index()
    {
        $weightClasses = WeightClass::all(); // Holt alle Gewichtsklassen aus der Datenbank
        $this->render("weight-classes-overview.html.twig", ["weightClasses" => $weightClasses]); // Übergibt die Gewichtsklassen an die View
    }

    /**
     * Zeigt das Formular zum Erstellen einer neuen Gewichtsklasse.
     */
    public function create()
    {
        $this->render("weight-class-form.html.twig"); // Zeigt das Formular für die Gewichtsklasse
    }

    /**
     * Speichert eine neue Gewichtsklasse in der Datenbank.
     *
     * @param array $data Eingabedaten für die neue Gewichtsklasse
     */
    public function store(array $data)
    {
        // Validierung: Überprüfen, ob der Name der Gewichtsklasse angegeben wurde
        if (empty($data['class_name'])) {
            $this->render("weight-class-form.html.twig", ["error" => "Der Name der Gewichtsklasse darf nicht leer sein."]);
            return;
        }

        $weightClass = new WeightClass();
        $weightClass->setclass_name($data['class_name']); // Konsistenter Methodenname
        try {
            $weightClass->save();
            $this->redirect("/weight-classes"); // Weiterleitung zur Gewichtsklassenübersicht
        } catch (\Exception $e) {
            $this->render("weight-class-form.html.twig", ["error" => "Fehler beim Speichern der Gewichtsklasse: " . $e->getMessage()]);
        }
    }

    /**
     * Zeigt das Formular zum Bearbeiten einer Gewichtsklasse.
     *
     * @param int $id ID der zu bearbeitenden Gewichtsklasse
     */
    public function edit(int $id)
    {
        $weightClass = WeightClass::find($id);
        if (!$weightClass) {
            $this->redirect("/weight-classes");
        }

        $this->render("weight-class-form.html.twig", ["weightClass" => $weightClass]);
    }

    /**
     * Aktualisiert eine bestehende Gewichtsklasse.
     *
     * @param int $id ID der Gewichtsklasse
     * @param array $data Eingabedaten für die Aktualisierung
     */
    public function update(int $id, array $data)
    {
        if (empty($data['class_name'])) {
            $this->render("weight-class-form.html.twig", ["error" => "Der Name der Gewichtsklasse darf nicht leer sein."]);
            return;
        }

        $weightClass = WeightClass::find($id);
        if (!$weightClass) {
            $this->redirect("/weight-classes");
        }

        $weightClass->setclass_name($data['class_name']); // Konsistenter Methodenname
        try {
            $weightClass->save();
            $this->redirect("/weight-classes"); // Weiterleitung nach erfolgreicher Aktualisierung
        } catch (\Exception $e) {
            $this->render("weight-class-form.html.twig", ["error" => "Fehler beim Aktualisieren der Gewichtsklasse: " . $e->getMessage()]);
        }
    }

    /**
     * Löscht eine Gewichtsklasse.
     *
     * @param int $id ID der Gewichtsklasse
     */
    public function delete(int $id)
    {
        $weightClass = WeightClass::find($id);
        if ($weightClass) {
            try {
                $weightClass->delete();
            } catch (\Exception $e) {
                $this->render("weight-classes-overview.html.twig", ["error" => "Fehler beim Löschen der Gewichtsklasse: " . $e->getMessage()]);
                return;
            }
        }

        $this->redirect("/weight-classes"); // Weiterleitung zur Gewichtsklassenübersicht
    }
}
