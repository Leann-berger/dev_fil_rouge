<?php

namespace App\Controller;

use App\Service\NoterSourcerService;

class NoterSourcerController extends AbstractController
{
    
    private NoterSourcerService $noterSourcerService;

    public function __construct() 
    { 
        $this->noterSourcerService = new NoterSourcerService(); 
    }

    public function noterSourcer(): void
    {
        // page accessible que si connecter
        if (!isset($_SESSION["user"])) {
            header("Location: /login");
            exit;
        }

        $data = [];

        // check si le formulaire à eté submit
        if (isset($_POST["submit"])) {


        //envoie les données au service
          
        $userId = $_SESSION["user"]["id"];
        $result = $this->noterSourcerService->submit($_POST, $userId);

        //on garde le message pour l'accueil, puis on redirige
        if ($result["success"]) {
            $_SESSION["flash"] = $result["msg"];
            header("Location: /");
            exit;
        }

        //on garde le message d'erreur pour ré-afficher le formulaire
        $data["msg"] = $result["msg"];
            
        }

        //
        $formData = $this->noterSourcerService->getFormData();
        $data["brandCategories"] = $formData["brandCategories"];
        $data["gradeCategories"] = $formData["gradeCategories"];

        // affichage du formulaire
        $this->render("noter_sourcer", "Noter et Sourcer", $data);
    }
}