<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class DefaultController
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader("views");
        $this->twig = new Environment($loader, [
            'cache' => false,
            'debug' => true,
        ]);

        $this->twig->addGlobal('session', $_SESSION); // Globale Session-Variable verfügbar machen
    }

    protected function render(string $view, array $params = [])
    {
        echo $this->twig->render($view, $params);
    }

    protected function redirect(string $path)
    {
        header("Location: $path");
        exit();
    }

    protected function checkAuthentication()
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect("/login");
        }
    }
}
