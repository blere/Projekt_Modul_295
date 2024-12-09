<?php

namespace App\Controller;

use App\Model\Fighter;
use App\Model\Arena;
use App\Model\Fight;

class HomeController extends DefaultController
{
    public function index()
    {
        $this->checkAuthentication();
        $fighters = Fighter::all();
        $arenas = Arena::all();
        $fights = Fight::all();

        $this->render("home.html.twig", [
            "fighters" => $fighters,
            "arenas" => $arenas,
            "fights" => $fights,
        ]);
    }
}
