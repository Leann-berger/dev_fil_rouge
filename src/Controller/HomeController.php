<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    public function home(): void
    {
        $this->render("home", "Accueil");
    }
}