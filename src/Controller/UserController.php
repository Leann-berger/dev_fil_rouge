<?php

namespace App\Controller;

use App\Service\UserService;

class UserController extends AbstractController
{
    private UserService $userService;

    public function login(): void
    {
         //redirection vers accueil si connecté
        if (isset($_SESSION["user"])) {
            header('Location:/');
        }

        //Test si le formulaire est soumis
        if (isset($_POST["submit"])) {
            //Traitement de la connexion
            $data = $this->userService->connectUser();
        }
        //Retourne la vue
        $this->render('login', 'Connexion', $data ?? []);
    }
    
    public function register(): void
    {
        //redirection vers accueil si connecté
        if (isset($_SESSION["user"])) {
            header('Location:/');
        }
        //Tester si le formulaire est soumis
        if (isset($_POST["submit"])) {
            $data["msg"] = $this->userService->insertUser();
        }
        //Retourne la vue 
        $this->render('register', 'Inscription', $data ?? []);
    }
}