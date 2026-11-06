<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    public function home(): mixed
    {
        $this->render("home", "Accueil");
    }
}