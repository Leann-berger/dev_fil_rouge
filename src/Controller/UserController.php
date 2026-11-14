<?php

namespace App\Controller;

use App\Service\UserService;

class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function login(): void
    {
        //redirection vers accueil si connecté
        if (isset($_SESSION["user"])) {
            header('Location:/');
            exit;
        }

        //Test si le formulaire est soumis
        if (isset($_POST["submit"])) {
            //Traitement de la connexion
            $data = $this->userService->connectUser();

            if (!empty($data["success"])) {
                header('Location: /');
            exit;
            }
        }
        //Retourne la vue
        $this->render('login', 'Connexion', $data ?? []);
    }
    
    public function register(): void
    {
        //redirection vers accueil si connecté
        if (isset($_SESSION["user"])) {
            header('Location:/');
            exit;
        }
        //Tester si le formulaire est soumis
        if (isset($_POST["submit"])) {
            $data["msg"] = $this->userService->insertUser();
        }
        
        //Retourne la vue 
        $this->render('register', 'Inscription', $data ?? []);
    }


    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /');
        exit;
    }
}